<?php

namespace App\Repository;

use App\Entity\UserPrivatToken;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserPrivatToken|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserPrivatToken|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserPrivatToken[]    findAll()
 * @method UserPrivatToken[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserPrivatTokenRepository extends ServiceEntityRepository implements UserPrivatTokenRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserPrivatToken::class);
    }

    // /**
    //  * @return UserPrivatToken[] Returns an array of UserPrivatToken objects
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
    public function findOneBySomeField($value): ?UserPrivatToken
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
