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

        $this->setFormatDate();
        $this->setStartDate();
        $this->setEndDate();
        $this->setDiff();
        $this->setData();
    }

    public function setView(string $view)
    {
        $this->view = $view;
    }

    public function setFormatDate()
    {
        if($this->view == 'week') {
            $this->format = 'W.Y';
        }

        if($this->view == 'day') {
            $this->format = 'j.n.Y';
        }

        if($this->view == 'month') {
            $this->format = 'n.Y';
        }

        if($this->view == 'year') {
            $this->format = 'Y';
        }
    }

    public function setStartDate()
    {
        $startDate = ($this->income[0]['time'] > $this->expense[0]['time']) ? $this->expense[0]['time'] : $this->income[0]['time'];
        $this->startDate = Carbon::createFromTimestamp($startDate);
    }

    public function getStartDate(): Carbon
    {
        return $this->startDate;
    }

    public function setEndDate()
    {
        $endDate = (end($this->income)['time'] > end($this->expense)['time']) ? end($this->income)['time'] : end($this->expense)['time'];
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
        }

        if($this->view == 'day') {
            $this->diff = $this->startDate->diffInDays($this->endDate);
        }

        if($this->view == 'month') {
            $this->diff = $this->startDate->diffInMonths($this->endDate);
        }

        if($this->view == 'year') {
            $this->diff = $this->startDate->diffInYears($this->endDate);
        }

        // TODO Rework diff
        $this->diff = $this->diff + 2;
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

        if($this->view == 'month') {
            return $array['month'].'.'.$array['year'];
        }

        if($this->view == 'year') {
            return $array['year'];
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

        if($this->view == 'month') {
            $this->startDate->addMonth();
        }

        if($this->view == 'year') {
            $this->startDate->addYear();
        }


    }

    public function setData()
    {
        for($i = 1; $i <= $this->diff; $i++) {
            $this->dataLabels[] = $this->startDate->format($this->format);
            $this->dataIncome[$this->startDate->format($this->format)] = 0;
            $this->dataExpense[$this->startDate->format($this->format)] = 0;

            $this->setNextStep();
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