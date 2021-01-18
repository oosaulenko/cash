<?php


namespace App\Repository;

interface UserMonobankTokenRepositoryInterface {


    /**
     * @param $user
     */
    public function getToken($user);

    /**
     * @param $user
     */
    public function getTokenID($user);


}