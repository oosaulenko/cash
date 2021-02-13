<?php


namespace App\Controller\Main;

use App\Repository\TransactionRepositoryInterface;
use App\Service\Data\DataService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DataController extends BaseController {

    /**
     * @var TransactionRepositoryInterface
     */
    private $transactionRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * @Route("/data/transactions", name="data_card_transactions", methods={"GET", "POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function getTransactionsByCard(Request $request): JsonResponse
    {
        $card_id = (int) $request->get('card_id');

        $response['transactions'] = $this->transactionRepository->getLastTransactions([$card_id])->getArrayResult();

        return $this->json($response);
    }

}