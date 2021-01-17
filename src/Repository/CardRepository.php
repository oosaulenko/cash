<?php

namespace App\Repository;

use App\Entity\Card;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Monobank\Exception\InternalErrorException;
use Monobank\Exception\InvalidAccountException;
use Monobank\Exception\MonobankException;
use Monobank\Exception\TooManyRequestsException;
use Monobank\Exception\UnknownTokenException;
use Monobank\Monobank;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Card|null find($id, $lockMode = null, $lockVersion = null)
 * @method Card|null findOneBy(array $criteria, array $orderBy = null)
 * @method Card[]    findAll()
 * @method Card[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardRepository extends ServiceEntityRepository implements CardRepositoryInterface {

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var UserInterface
     */
    private $user;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager, TokenStorageInterface $user) {
        parent::__construct($registry, Card::class);
        $this->entityManager = $entityManager;
        $this->user = $user;
    }

    // /**
    //  * @return Card[] Returns an array of Card objects
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
    public function findOneBySomeField($value): ?Card
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
     * @param $user
     * @return array
     */
    public function getCards($user): array {

        return parent::findBy([
            'user' => $user
        ]);
    }

    /**
     * @param $token
     * @return mixed|void
     */
    public function getListCardMonobankAPI($token) {

        try{
            $monobank = new Monobank($token);
        }
        catch(InternalErrorException $e){
            return $e->getMessage();
        }

        try {
            return $monobank->personal->getClientInfo()->accounts();
        } catch(InternalErrorException $e) {
            return $e->getMessage();
        } catch(InvalidAccountException $e) {
            return $e->getMessage();
        } catch(MonobankException $e) {
            return $e->getMessage();
        } catch(TooManyRequestsException $e) {
            return $e->getMessage();
        } catch(UnknownTokenException $e) {
            return $e->getMessage();
        }

    }
}
