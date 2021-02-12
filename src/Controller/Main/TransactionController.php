<?php


namespace App\Controller\Main;


use App\Form\FilterTransactionType;
use App\Repository\CardRepositoryInterface;
use App\Repository\TransactionRepositoryInterface;
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

    public function __construct(TransactionRepositoryInterface $transactionRepository, CardRepositoryInterface $cardRepository, DataService $dataService)
    {
        $this->transactionRepository = $transactionRepository;
        $this->cardRepository = $cardRepository;
        $this->dataService = $dataService;
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

        $forRender['transactions'] = $this->transactionRepository->setParams($filterParams)->getTransactions($cards);
        $forRender['sumIncome'] = $this->transactionRepository->setParams($filterParams)->getIncome($cards);
        $forRender['sumExpense'] = $this->transactionRepository->setParams($filterParams)->getExpense($cards);

        if(!isset($request->get('filter_transaction')['amountFrom'])) {
            $filterParams['amountFrom'] = $forRender['sumExpense'];
        }

        if(!isset($request->get('filter_transaction')['amountTo'])) {
            $filterParams['amountTo'] = $forRender['sumIncome'];
        }

        $getIncome = $this->transactionRepository->getIncomeChart($cards);


        $getExpense = $this->transactionRepository->getExpenseChart($cards);

        $getFirstDateIncome = strtotime($getIncome[0]['year'].'-'.$getIncome[0]['month'].'-'.$getIncome[0]['day']);
        $getFirstDateExpense = strtotime($getExpense[0]['year'].'-'.$getExpense[0]['month'].'-'.$getExpense[0]['day']);

        $getLastDateIncome = end($getIncome);
        $getLastDateIncome = strtotime($getLastDateIncome['year'].'-'.$getLastDateIncome['month'].'-'.$getLastDateIncome['day']);

        $getLastDateExpense = end($getExpense);
        $getLastDateExpense = strtotime($getLastDateExpense['year'].'-'.$getLastDateExpense['month'].'-'.$getLastDateExpense['day']);

        $firstDate = ($getFirstDateIncome > $getFirstDateExpense) ? $getFirstDateExpense : $getFirstDateIncome;
        $lastDate = ($getLastDateIncome > $getLastDateExpense) ? $getLastDateIncome : $getLastDateExpense;

        $firstDateD = Carbon::createFromTimestamp($firstDate);
        $lastDateD = Carbon::createFromTimestamp($lastDate);
        $countDays = $firstDateD->diffInDays($lastDateD);

        for($i = 1; $i <= $countDays; $i++) {
            $date = $firstDateD->addDay();

//            $date = $date->format('j.n.Y');

            $labels[] = $date->format('j.n.Y');
            $dataIncome[$date->format('j.n.Y')] = 0;
            $dataExpense[$date->format('j.n.Y')] = 0;
        }

        foreach($getIncome as $value) {
            $date = $value['day'].'.'.$value['month'].'.'.$value['year'];
            $dataIncome[$date] = $value['sum'];
        }

        foreach($getExpense as $value) {
            $date = $value['day'].'.'.$value['month'].'.'.$value['year'];
            $dataExpense[$date] = abs($value['sum']);
        }

        $labels = array_values($labels);
        $dataIncome = array_values($dataIncome);
        $dataExpense = array_values($dataExpense);

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Доходы',
                    'backgroundColor' => 'rgba(255, 99, 132, 0)',
                    'borderColor' => '#84DEAD',
                    'data' => $dataIncome,
                ],
                [
                    'label' => 'Расходы',
                    'backgroundColor' => 'rgba(255, 99, 132, 0)',
                    'borderColor' => '#7ABFF8',
                    'data' => $dataExpense,
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