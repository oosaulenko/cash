<?php


namespace App\Service;


use App\Repository\UserMonobankTokenRepositoryInterface;

interface FormServiceInterface {

    /**
     * @param UserMonobankTokenRepositoryInterface $userMonobankTokenRepository
     * @return mixed
     */
    public function formMonobankToken(UserMonobankTokenRepositoryInterface $userMonobankTokenRepository);

}