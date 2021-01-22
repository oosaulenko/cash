<?php

namespace App\Repository;

use App\Entity\CategoryMcc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoryMcc|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryMcc|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryMcc[]    findAll()
 * @method CategoryMcc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryMccRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryMcc::class);
    }

    // /**
    //  * @return CategoryMcc[] Returns an array of CategoryMcc objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CategoryMcc
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
