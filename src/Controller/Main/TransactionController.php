<?php


namespace App\Controller\Main;


use App\Form\FilterTransactionType;
use App\Repository\CardRepositoryInterface;
use App\Repository\TransactionRepositoryInterface;
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

    public function __construct(TransactionRepositoryInterface $transactionRepository, CardRepositoryInterface $cardRepository) {
        $this->transactionRepository = $transactionRepository;
        $this->cardRepository = $cardRepository;
    }

    /**
     * @Route("/transactions", name="transactions", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Транзакции';

        $cards = $this->cardRepository->getCardsID($this->getUser());
        $forRender['transactions'] = $this->transactionRepository->getTransactions($cards, [
//            'sort' => $request->get('filter_transaction')['sort']
            'sort' => 'DESC'
        ]);
        $forRender['sumIncome'] = $this->transactionRepository->getIncome($cards, []);
        $forRender['sumExpense'] = $this->transactionRepository->getExpense($cards, []);

        $filterForm = $this->createForm(FilterTransactionType::class, $request->get('filter_transaction'));
        $forRender['filterForm'] = $filterForm->createView();
        $filterForm->handleRequest($request);


        return $this->render('main/transaction/index.html.twig', $forRender);
    }

}