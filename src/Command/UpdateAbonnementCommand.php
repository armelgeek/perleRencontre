<?php

namespace App\Command;

use App\Entity\MonCoffre;
use App\Entity\MonProfil;
use App\Entity\Utilisateur;
use DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class UpdateAbonnementCommand extends Command
{
    protected static $defaultName = 'app:update-abonnement';
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setDescription('Update abonnement')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        $users =  $this->em->getRepository(Utilisateur::class)->findAll();
        foreach($users as $user){
            $profile =  $this->em->getRepository(MonProfil::class)->findOneBy(array('user' => $user->getId()));
            $moncoffre =   $this->em->getRepository(MonCoffre::class)->findOneBy(array('profil' => $profile , 'isExpired' => false));
            $isExpired = $moncoffre->getExpiredAt() > new DateTime();
            $diff = intval(date_diff($moncoffre->getExpiredAt(), new DateTime())->format('%R%a'));
            $moncoffre->setIsExpired($isExpired);
            $validate_number = $moncoffre->getValidationNumber();
            $abonnement = $moncoffre->getAbonnement();
            if(!$isExpired){
                // Effectue le reabonnement avant 10 jours
                if($validate_number > 1 and $diff == 10){
                    // Payement processing
                    $stripe = new  \Stripe\StripeClient($_ENV['STRIPE_TOKEN']);
                    try {
                        // save customer for next payement
                        $charge = $stripe->charges->create(
                            array(
                                'amount' => $abonnement->getPrice(),
                                'currency' => 'euro',
                                'description' => "Mise à jour de l'abonnement",
                                'customer' =>  $moncoffre->getCustomerId(),
                            )
                        );
                        // get charge information
                        $capture = $stripe->charges->capture(
                            $charge['id'],
                            [],
                        );
                        // validate transaction
                        $moncoffre->setTranscation(array($capture));
                    } catch (\Stripe\Exception\CardException $e) {
                        $moncoffre->setTranscation(null);
                    } catch (\Stripe\Exception\RateLimitException $e) {
                        $moncoffre->setTranscation(null);
                    } catch (\Stripe\Exception\InvalidRequestException $e) {
                        $moncoffre->setTranscation(null);
                    } catch (\Stripe\Exception\AuthenticationException $e) {
                        $moncoffre->setTranscation(null);
                    } catch (\Stripe\Exception\ApiConnectionException $e) {
                        $moncoffre->setTranscation(null);
                    } catch (\Stripe\Exception\ApiErrorException $e) {
                        $moncoffre->setTranscation(null);
                    }

                }
            }else{
                if($validate_number > 1 && $moncoffre->getTranscation() != null){
                    // Update abonnement
                    $moncoffre->setAbonnement($abonnement);
                    $moncoffre->setValidationNumber($validate_number - 1);
                    $profile->setPerle($abonnement->getPerle());
                }
                else{
                    // Reset abonnement
                    $default_abonnement = $this->em->getRepository(Abonnement::class)->findOneBy(array('name' => 'Defaut'));
                    $moncoffre->setValidationNumber(1);
                    $moncoffre->setAbonnement($default_abonnement);
                    $profile->setPerle($default_abonnement->getPerle());
                }
                $moncoffre->setIsExpired(false);
                $moncoffre->setExpiredAt(new DateTime('now +30 days'));
            }
            $this->em->persist($profile);
            $this->em->persist($moncoffre);
            $this->em->flush();
        }

        $io->writeln(serialize($users));
        $io->success('Abonnement updated OK');
        return Command::SUCCESS;
    }

}
