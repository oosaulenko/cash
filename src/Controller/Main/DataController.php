<?php


namespace App\Controller\Main;

use App\Service\Data\DataService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DataController extends BaseController {

    /**
     * @var DataService
     */
    private $dataService;

    public function __construct(DataService $dataService)
    {
        $this->dataService = $dataService;
    }

    /**
     * @Route("/data/transaction", name="data_transaction", methods={"GET", "POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function getFilterTransactionAction(Request $request): JsonResponse
    {
        $response = $this->dataService->getFilterTransaction($request, $this->getUser());
        return $this->json($response);
    }
}