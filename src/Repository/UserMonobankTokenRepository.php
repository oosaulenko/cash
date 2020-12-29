<?php

namespace App\Repository;

use App\Entity\UserMonobankToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserMonobankToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserMonobankToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserMonobankToken[]    findAll()
 * @method UserMonobankToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserMonobankTokenRepository extends ServiceEntityRepository implements UserMonobankTokenRepositoryInterface {

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, UserMonobankToken::class);
    }

    // /**
    //  * @return UserMonobankToken[] Returns an array of UserMonobankToken objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserMonobankToken
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * @param $user
     * @return object|null
     */
    public function getToken($user): ?object {
        return parent::findOneBy(['user' => $user]);
    }
}
