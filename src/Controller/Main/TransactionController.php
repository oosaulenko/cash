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
        $forRender['body_class'] = 'active--filter';

        $filterParams = $this->dataService->getFilterTransactionParams($request);
        $cards = $this->cardRepository->getCardsID($this->getUser());

        dump($filterParams);

        $forRender['transactions'] = $this->transactionRepository->setParams($filterParams)->getTransactions($cards);
        $forRender['sumIncome'] = $this->transactionRepository->setParams($filterParams)->getIncome($cards);
        $forRender['sumExpense'] = $this->transactionRepository->setParams($filterParams)->getExpense($cards);

        if(!isset($request->get('filter_transaction')['amountFrom'])) {
            $filterParams['amountFrom'] = $forRender['sumExpense'];
        }

        if(!isset($request->get('filter_transaction')['amountTo'])) {
            $filterParams['amountTo'] = $forRender['sumIncome'];
        }

        $filterForm = $this->createForm(FilterTransactionType::class, $filterParams);
        $forRender['filterForm'] = $filterForm->createView();

        if($request->get('filter_transaction')) {
            $filterForm->handleRequest($request);
        }


        return $this->render('main/transaction/index.html.twig', $forRender);
    }

}