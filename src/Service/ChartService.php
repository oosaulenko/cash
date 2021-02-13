<?php


namespace App\Service;


use Carbon\Carbon;

class ChartService implements ChartServiceInterface {


    /**
     * @var $expense
     */
    private $expense;

    /**
     * @var $income
     */
    private $income;

    /**
     * @var
     */
    private $view;

    /**
     * @var
     */
    private $startDate;

    /**
     * @var
     */
    private $endDate;

    /**
     * @var
     */
    private $diff;

    private $format;

    private $dataLabels;

    private $dataIncome;

    private $dataExpense;

    public function __construct()
    {
        $this->view = 'week';
    }

    public function setIncome($income)
    {
        $this->income = $income;
    }

    public function setExpense($expense)
    {
        $this->expense = $expense;

        $this->setStartDate();
        $this->setEndDate();
        $this->setDiff();
        $this->setData();
    }

    public function setView(string $view)
    {
        $this->view = $view;
    }

    public function setStartDate()
    {
        $startDateIncome = strtotime($this->income[0]['year'] . '-' . $this->income[0]['month'] . '-' . $this->income[0]['day']);
        $startDateExpense = strtotime($this->expense[0]['year'] . '-' . $this->expense[0]['month'] . '-' . $this->expense[0]['day']);
        $startDate = ($startDateIncome > $startDateExpense) ? $startDateExpense : $startDateIncome;
        $this->startDate = Carbon::createFromTimestamp($startDate);
    }

    public function getStartDate(): Carbon
    {
        return $this->startDate;
    }

    public function setEndDate()
    {
        $endDateIncome = end($this->income);
        $endDateIncome = strtotime($this->setFormat($endDateIncome));

        $endDateExpense = end($this->expense);
        $endDateExpense = strtotime($endDateExpense['year'] . '-' . $endDateExpense['month'] . '-' . $endDateExpense['day']);

        $endDate = ($endDateIncome > $endDateExpense) ? $endDateIncome : $endDateExpense;
        $this->endDate = Carbon::createFromTimestamp($endDate);
    }

    public function getEndDate(): Carbon
    {
        return $this->endDate;
    }

    public function setDiff()
    {
        if($this->view == 'week') {
            $this->diff = $this->startDate->diffInWeeks($this->endDate);
            $this->format = 'W.Y';
        }

        if($this->view == 'day') {
            $this->diff = $this->startDate->diffInDays($this->endDate);
            $this->format = 'j.n.Y';
        }
    }

    public function getDiff()
    {
        return $this->diff;
    }

    public function setFormat(array $array): string
    {
        if($this->view == 'week') {
            return $array['week'].'.'.$array['year'];
        }

        if($this->view == 'day') {
            return $array['day'].'.'.$array['month'].'.'.$array['year'];
        }

        return false;
    }

    public function setNextStep()
    {
        if($this->view == 'week') {
            $this->startDate->addWeek();
        }

        if($this->view == 'day') {
            $this->startDate->addDay();
        }
    }

    public function setData()
    {
        for($i = 1; $i <= $this->diff; $i++) {
            $this->setNextStep();

            $this->dataLabels[] = $this->startDate->format($this->format);
            $this->dataIncome[$this->startDate->format($this->format)] = 0;
            $this->dataExpense[$this->startDate->format($this->format)] = 0;
        }

        foreach($this->income as $value) {
            $date = $this->setFormat($value);
            $this->dataIncome[$date] = $value['sum'];
        }

        foreach($this->expense as $value) {
            $date = $this->setFormat($value);
            $this->dataExpense[$date] = abs($value['sum']);
        }
    }

    public function getDataLabels(): array
    {
        return array_values($this->dataLabels);
    }

    public function getDataIncome(): array
    {
        return array_values($this->dataIncome);
    }

    public function getDataExpense(): array
    {
        return array_values($this->dataExpense);
    }
}