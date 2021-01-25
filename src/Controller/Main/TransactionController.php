<?php


namespace App\Controller\Main;


use App\Repository\TransactionRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransactionController extends BaseController {

    /**
     * @var TransactionRepositoryInterface
     */
    private $transactionRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository) {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * @Route("/transactions", name="transactions")
     */
    public function index(): Response {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Транзакции';

//        dump($this->transactionRepository->getTransactions($this->getUser()));

        return $this->render('main/transaction/index.html.twig', $forRender);
    }

}