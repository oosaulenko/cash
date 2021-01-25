<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\CardRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UpdateCardCommand extends Command
{
    protected static $defaultName = 'UpdateCard';

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var CardRepositoryInterface
     */
    private $cardRepository;

    public function __construct(string $name = null, EntityManagerInterface $entityManager, CardRepositoryInterface $cardRepository) {
        parent::__construct($name);

        $this->entityManager = $entityManager;
        $this->cardRepository = $cardRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $users = $this->entityManager->getRepository(User::class)->findAll();

        foreach($users as $user) {
            $this->cardRepository->updateMonobankTransactions($user);
        }

        $io->success('Updated cards');

        return Command::SUCCESS;
    }
}
