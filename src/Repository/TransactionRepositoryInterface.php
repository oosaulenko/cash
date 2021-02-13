<?php


namespace App\Repository;


use App\Entity\Card;
use Monobank\Response\Model\Statement;

interface TransactionRepositoryInterface {

    /**
     * @param Statement $statement
     * @param Card $card
     * @return mixed
     */
    public function create( Statement $statement, Card $card);

    /**
     * @param Statement $statement
     * @return mixed
     */
    public function findCategory(Statement $statement);

    /**
     * @param $cards
     * @return mixed
     */
    public function getTransactions($cards);

    /**
     * @param $card
     * @return mixed
     */
    public function getLastTransactions($card);

    /**
     * @param $cards
     * @return mixed
     */
    public function getIncome($cards);

    /**
     * @param $cards
     * @param $view
     * @return mixed
     */
    public function getIncomeChart($cards, $view);

    /**
     * @param $cards
     * @param $view
     * @return mixed
     */
    public function getExpenseChart($cards, $view);

    /**
     * @param $cards
     * @return mixed
     */
    public function getExpense($cards);

    /**
     * @param $params
     * @return mixed
     */
    public function setParams($params);

    /**
     * @param $query
     * @return mixed
     */
    public function setFilterParams($query);

}