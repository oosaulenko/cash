<?php


namespace App\Controller\Main;


use App\Repository\CardRepositoryInterface;
use App\Repository\TransactionRepositoryInterface;
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
     * @Route("/transactions", name="transactions")
     */
    public function index(): Response {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Транзакции';

        $cards = $this->cardRepository->getCardsID($this->getUser());
        $forRender['transactions'] = $this->transactionRepository->getTransactions($cards);

        dump($forRender['transactions']);

        return $this->render('main/transaction/index.html.twig', $forRender);
    }

}