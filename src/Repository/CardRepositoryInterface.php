<?php


namespace App\Repository;


use App\Entity\Card;

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
     * @param $user
     * @return array
     */
    public function getCardsID($user): array;

    /**
     * @param $user
     * @return array
     */
    public function getCardsMonobank($user): array;

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

    /**
     * @param $token
     * @param $keyCard
     * @param $from
     * @param $to
     * @return mixed
     */
    public function getCardTransactions($token, $keyCard, $from, $to);


    /**
     * @param $user
     * @return mixed
     */
    public function updateMonobankTransactions($user);

    /**
     * @param Card $card
     * @param $time
     * @return Card
     */
    public function updateTime(Card $card, int $time): Card;

}