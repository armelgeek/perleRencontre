<?php

namespace App\Command;

use App\Entity\AutorisedUser;
use App\Entity\MessageBourse;
use App\Entity\MessagePerle;
use App\Entity\Utilisateur;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;

class MesagePerleUpdateCommand extends Command
{
    protected static $defaultName = 'app:mesage-perle-update';

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }
    protected function configure()
    {
        $this->setDescription('Add a short description for your command')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $messagePerles =  $this->em->getRepository(MessagePerle::class)->findBy(array('isExpired'=>false));
        $messageBourse = $this->em->getRepository(MessageBourse::class)->findBy(array('isExpired' => false));
        foreach($messagePerles as $mp){
            $createdDate = $mp->getExpiredAt();
            $diff = intval(date_diff($createdDate, new DateTime())->format('%R%a'));
            if ($diff == 0) {
                $mp->setIsExpired(true);
                $this->em->persist($mp);
            }
        }
        foreach($messageBourse as $mb){
            $createdDate = $mb->getExpiredAt();
            $diff = intval(date_diff($createdDate, new DateTime())->format('%R%a'));
            if ($diff == 0) {
                $mb->setIsExpired(true);
                if ($mb->getIsExpired() && !$mb->getIsAccepted() && !$mb->getInRefused()) {
                    // penalisé la fille pour ce cas
                    $receiver = $mb->getReceiver();
                    $nbperlepenalty = 1;
                    $profile = $this->em->getRepository(MonProfil::class)->findOneBy(array('user' => $receiver));
                    $profile->setPerle($profile->getPerle() - $nbperlepenalty);
                    $this->em->persist($profile);
                }
                // refuser auto si la date est expirée
                $mb->setIsRefused(true);
                $this->em->persist($mb);
            }
        }
        $this->em->flush();
        $io->success('Updated message perle and message bourse');
        return Command::SUCCESS;
    }
}
