<?php

namespace App\Command;

use App\Entity\Message;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;
class RemoveMessageCommand extends Command
{
    protected static $defaultName = 'app:remove-message';

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }
    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $messages =  $this->em->getRepository(Message::class)->findAll();
        foreach($messages as $message){
            $createdDate = $message->getCreatedAt();
            $diff = intval(date_diff($createdDate, new DateTime())->format('%R%a'));
            if($diff > 10){
                $this->em->remove($message);
            }
        }
        $this->em->flush();
        $io->success('Old message removed');

        return Command::SUCCESS;
    }
}