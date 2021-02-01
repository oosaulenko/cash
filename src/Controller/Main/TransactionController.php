<?php


namespace App\Controller\Main;


use App\Form\FilterTransactionType;
use App\Repository\CardRepositoryInterface;
use App\Repository\TransactionRepositoryInterface;
use App\Service\Data\DataService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransactionController extends BaseController {

    /**
     * @var TransactionRepositoryInterface
     */
    private $transactionRepository;

    /**
     * @var CardRepositoryInterface
     */
    private $cardRepository;
    /**
     * @var DataService
     */
    private $dataService;

    public function __construct(TransactionRepositoryInterface $transactionRepository, CardRepositoryInterface $cardRepository, DataService $dataService)
    {
        $this->transactionRepository = $transactionRepository;
        $this->cardRepository = $cardRepository;
        $this->dataService = $dataService;
    }

    /**
     * @Route("/transactions", name="transactions", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Транзакции';

        $filterParams = $this->dataService->getFilterTransactionParams($request);
        $cards = $this->cardRepository->getCardsID($this->getUser());

        $forRender['transactions'] = $this->transactionRepository->setParams($filterParams)->getTransactions($cards);
        $forRender['sumIncome'] = $this->transactionRepository->getIncome($cards);
        $forRender['sumExpense'] = $this->transactionRepository->getExpense($cards);

        $filterForm = $this->createForm(FilterTransactionType::class, $filterParams);
        $forRender['filterForm'] = $filterForm->createView();

        if($request->get('filter_transaction')) {
            $filterForm->handleRequest($request);
        }


        return $this->render('main/transaction/index.html.twig', $forRender);
    }

}