<?php


namespace App\Service;


use Carbon\Carbon;

interface ChartServiceInterface {

    /**
     * @param $income
     * @return mixed
     */
    public function setIncome($income);

    /**
     * @param $expense
     * @return mixed
     */
    public function setExpense($expense);

    /**
     * @param string $view
     */
    public function setView(string $view);

    /**
     * @return mixed
     */
    public function setFormatDate();

    /**
     * @return mixed
     */
    public function setStartDate();

    /**
     * @return mixed
     */
    public function getStartDate(): Carbon;

    /**
     * @return mixed
     */
    public function setEndDate();

    /**
     * @return mixed
     */
    public function getEndDate(): Carbon;

    /**
     * @return mixed
     */
    public function getDiff();

    /**
     * @return mixed
     */
    public function setDiff();

    /**
     * @param array $array
     * @return string
     */
    public function setFormat(array $array): string;

    /**
     * @return mixed
     */
    public function setNextStep();

    /**
     * @return mixed
     */
    public function setData();

    public function getDataLabels();

    public function getDataIncome();

    public function getdataExpense();

}