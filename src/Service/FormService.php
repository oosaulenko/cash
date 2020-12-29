<?php


namespace App\Service;


use App\Entity\UserMonobankToken;
use App\Repository\UserMonobankTokenRepositoryInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class FormService implements FormServiceInterface {

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var TokenInterface
     */
    private $token;

    public function __construct(EntityManager $entityManager, TokenInterface $token) {
        $this->em = $entityManager;
        $this->token = $token;
    }

    /**
     * @param UserMonobankTokenRepositoryInterface $userMonobankTokenRepository
     * @return mixed|void
     * @throws ORMException
     */
    public function formMonobankToken(UserMonobankTokenRepositoryInterface $userMonobankTokenRepository): UserMonobankToken {
        $userMonobankToken = $userMonobankTokenRepository->getToken($this->token->getUser());

        if(!$userMonobankToken){
            $userMonobankToken = new UserMonobankToken();
            $userMonobankToken->setUser($this->token->getUser());
            $this->em->persist($userMonobankToken);
        }

        return $userMonobankToken;
    }
}