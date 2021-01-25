<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\CategoryMcc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoryMcc|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryMcc|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryMcc[]    findAll()
 * @method CategoryMcc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryMccRepository extends ServiceEntityRepository implements CategoryMccRepositoryInterface {

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager) {
        parent::__construct($registry, CategoryMcc::class);

        $this->entityManager = $entityManager;
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

    /**
     * @param $code
     * @return CategoryMcc
     */
    public function findByCode($code): ?CategoryMcc {
        return parent::findOneBy([
            'code' => $code
        ]);
    }

    /**
     * @param $code
     * @param $name
     * @param $category
     */
    public function createMccCode($code, $name, $category) {
        $categoryMcc = new CategoryMcc();

        $categoryMcc->setName($name);
        $categoryMcc->setCode($code);
        $categoryMcc->setCategory($category);

        $this->entityManager->persist($categoryMcc);
        $this->entityManager->flush();
    }
}
