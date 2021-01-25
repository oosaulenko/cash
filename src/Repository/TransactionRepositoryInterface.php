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

}