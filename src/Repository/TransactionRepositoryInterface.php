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
     * @param array|null $params
     * @return mixed
     */
    public function getTransactions($cards, ?array $params);

    /**
     * @param $cards
     * @param array|null $params
     * @return mixed
     */
    public function getIncome($cards, ?array $params);

    /**
     * @param $cards
     * @param array|null $params
     * @return mixed
     */
    public function getExpense($cards, ?array $params);

}