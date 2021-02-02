<?php


namespace App\Service\Data;


use App\Repository\CardRepositoryInterface;
use App\Repository\CategoryRepositoryInterface;
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

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;


    public function __construct(ManagerRegistry $registry, TransactionRepositoryInterface $transactionRepository, CardRepositoryInterface $cardRepository, CategoryRepositoryInterface $categoryRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->cardRepository = $cardRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function getFilterTransaction(Request $request, $user)
    {
        $sort = $request->get('sort');

        return $this->transactionRepository->getTransactions($this->cardRepository->getCardsID($user));
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getFilterTransactionParams(Request $request): array
    {
        $filter = [];

        if($request->get('filter_transaction')) {
            if(!empty($request->get('filter_transaction')['typeIncome'])) $filter['typeIncome'] = (boolean) $request->get('filter_transaction')['typeIncome'];
            if(!empty($request->get('filter_transaction')['typeExpense'])) $filter['typeExpense'] = (boolean) $request->get('filter_transaction')['typeExpense'];
            if(!empty($request->get('filter_transaction')['sort'])) $filter['sort'] = $request->get('filter_transaction')['sort'];
            if(!empty($request->get('filter_transaction')['category'])) $filter['category'] = $this->categoryRepository->getCategories($request->get('filter_transaction')['category']);
        }

        return $filter;
    }

    public function setQueryFilterTransaction($query, $params)
    {

    }

}