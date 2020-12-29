<?php


namespace App\Repository;

interface UserMonobankTokenRepositoryInterface {


    /**
     * @param $user
     */
    public function getToken($user);


}