<?php


namespace App\Repository;


interface CardRepositoryInterface {

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

}