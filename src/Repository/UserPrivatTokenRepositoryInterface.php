<?php


namespace App\Repository;


interface UserPrivatTokenRepositoryInterface {


    /**
     * @param $user
     */
    public function getToken($user);

}