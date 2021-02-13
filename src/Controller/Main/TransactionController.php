<?php


namespace App\Controller\Main;


use App\Form\FilterTransactionType;
use App\Repository\CardRepositoryInterface;
use App\Repository\TransactionRepositoryInterface;
use App\Service\ChartServiceInterface;
use App\Service\Data\DataService;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

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
    /**
     * @var ChartServiceInterface
     */
    private $chartService;

    public function __construct(TransactionRepositoryInterface $transactionRepository, CardRepositoryInterface $cardRepository, DataService $dataService, ChartServiceInterface $chartService)
    {
        $this->transactionRepository = $transactionRepository;
        $this->cardRepository = $cardRepository;
        $this->dataService = $dataService;
        $this->chartService = $chartService;
    }

    /**
     * @Route("/transactions", name="transactions", methods={"GET"})
     * @param Request $request
     * @param ChartBuilderInterface $chartBuilder
     * @return Response
     */
    public function index(Request $request, ChartBuilderInterface $chartBuilder): Response
    {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Транзакции';
        $forRender['body_class'] = 'active--filter';

        $filterParams = $this->dataService->getFilterTransactionParams($request);
        $cards = $this->cardRepository->getCardsID($this->getUser());

        $this->transactionRepository->setParams($filterParams);

        $forRender['transactions'] = $this->transactionRepository->getTransactions($cards);
        $forRender['sumIncome'] = $this->transactionRepository->getIncome($cards);
        $forRender['sumExpense'] = $this->transactionRepository->getExpense($cards);


        if(!isset($request->get('filter_transaction')['amountFrom'])) {
            $filterParams['amountFrom'] = $forRender['sumExpense'];
        }

        if(!isset($request->get('filter_transaction')['amountTo'])) {
            $filterParams['amountTo'] = $forRender['sumIncome'];
        }

        $this->chartService->setIncome($this->transactionRepository->getIncomeChart($cards, 'week'));
        $this->chartService->setExpense($this->transactionRepository->getExpenseChart($cards, 'week'));

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => $this->chartService->getDataLabels(),
            'datasets' => [
                [
                    'label' => 'Доходы',
                    'backgroundColor' => 'rgba(255, 99, 132, 0)',
                    'borderColor' => '#84DEAD',
                    'data' => $this->chartService->getDataIncome(),
                ],
                [
                    'label' => 'Расходы',
                    'backgroundColor' => 'rgba(255, 99, 132, 0)',
                    'borderColor' => '#7ABFF8',
                    'data' => $this->chartService->getdataExpense(),
                ],
            ],
        ]);
        $chart->setOptions([
           'tooltips' => [
               'mode' => 'index',
               'intersect' => 'false',
               'caretSize' => 0,
               'backgroundColor' => '#252631',
               'borderWidth' => 0
           ],
           'hover' => [
               'mode' => 'index',
               'intersect' => 'false'
           ]
        ]);

        $filterForm = $this->createForm(FilterTransactionType::class, $filterParams);
        $forRender['filterForm'] = $filterForm->createView();
        $forRender['chart'] = $chart;

        if($request->get('filter_transaction')) {
            $filterForm->handleRequest($request);
        }


        return $this->render('main/transaction/index.html.twig', $forRender);
    }

}