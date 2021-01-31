<?php


namespace App\Service\Data;


use App\Repository\CardRepositoryInterface;
use App\Repository\TransactionRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class DataService {

    /**
     * @var TransactionRepositoryInterface
     */
    private $transactionRepository;

    /**
     * @var CardRepositoryInterface
     */
    private $cardRepository;


    public function __construct(ManagerRegistry $registry, TransactionRepositoryInterface $transactionRepository, CardRepositoryInterface $cardRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->cardRepository = $cardRepository;
    }

    public function getFilterTransaction(Request $request, $user)
    {
        $sort = $request->get('sort');

        return $this->transactionRepository->getTransactions($this->cardRepository->getCardsID($user), []);
    }

}