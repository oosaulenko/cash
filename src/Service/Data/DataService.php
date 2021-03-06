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
            if(!empty($request->get('filter_transaction')['timeFrom'])) $filter['timeFrom'] = $request->get('filter_transaction')['timeFrom'];
            if(!empty($request->get('filter_transaction')['timeTo'])) $filter['timeTo'] = $request->get('filter_transaction')['timeTo'];
            if(!empty($request->get('filter_transaction')['dateFrom'])) $filter['dateFrom'] = $request->get('filter_transaction')['dateFrom'];
            if(!empty($request->get('filter_transaction')['dateTo'])) $filter['dateTo'] = $request->get('filter_transaction')['dateTo'];
            if(!empty($request->get('filter_transaction')['amountFrom'])) $filter['amountFrom'] = $request->get('filter_transaction')['amountFrom'];
            if(!empty($request->get('filter_transaction')['amountTo'])) $filter['amountTo'] = $request->get('filter_transaction')['amountTo'];
        }

        return $filter;
    }

    public function setQueryFilterTransaction($query, $params)
    {

    }

}