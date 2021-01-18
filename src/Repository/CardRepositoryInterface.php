<?php


namespace App\Repository;


interface CardRepositoryInterface {

    /**
     * @param int $cardId
     * @return mixed
     */
    public function getOne(int $cardId);

    /**
     * @param $user
     * @return array
     */
    public function getCards($user): array;

    /**
     * @param $token
     * @return mixed
     */
    public function getListCardMonobankAPI($token);

    /**
     * @param $currency
     * @return string
     */
    public function getCurrencyCard($currency): string;

}