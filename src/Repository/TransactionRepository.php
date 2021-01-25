<?php

namespace App\Repository;

use App\Entity\Card;
use App\Entity\Transaction;
use Carbon\Carbon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Monobank\Response\Model\Statement;

/**
 * @method Transaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transaction[]    findAll()
 * @method Transaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransactionRepository extends ServiceEntityRepository implements TransactionRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @var CategoryMccRepositoryInterface
     */
    private $categoryMccRepository;

    /**
     * @var CardRepositoryInterface
     */
    private $cardRepository;


    public function __construct(ManagerRegistry $registry,
                                EntityManagerInterface $entityManager,
                                CategoryRepositoryInterface $categoryRepository,
                                CategoryMccRepositoryInterface $categoryMccRepository
    )
    {
        parent::__construct($registry, Transaction::class);

        $this->entityManager = $entityManager;
        $this->categoryRepository = $categoryRepository;
        $this->categoryMccRepository = $categoryMccRepository;
//        $this->cardRepository = $cardRepository;
    }

    /**
     * @param Statement $statement
     * @param Card $card
     * @return mixed|void
     */
    public function create(Statement $statement, Card $card): Transaction {

        $transaction = new Transaction();
        $transaction->setCard($card);
        $transaction->setCode($statement->id());
        $transaction->setCategory($this->findCategory($statement));
        $transaction->setDescription($statement->description());
        $transaction->setMcc($statement->mcc());
        $transaction->setAmount($statement->amount() / 100);
        $transaction->setCommission($statement->commissionRate() / 100);
        $transaction->setCashback($statement->cashbackAmount() / 100);
        $transaction->setTime(Carbon::parse($statement->time())->getTimestamp());

        $this->entityManager->persist($transaction);
        $this->entityManager->flush();

        return $transaction;
    }


    /**
     * @param Statement $statement
     * @return mixed|void
     */
    public function findCategory(Statement $statement) {
        $category = $this->categoryMccRepository->findByCode($statement->mcc());

        if($category) {
            $category = $category->getCategory();
        } else {
            $category = $this->categoryRepository->isDefault();
            $this->categoryMccRepository->createMccCode($statement->mcc(), '-0-', $this->categoryRepository->isDefault());
        }

        return $category;
    }

    public function getTransactions($user)
    {
        $cards = $this->cardRepository->getCards($user);

//        $cards = $this->cardRepository->getCards($user);
//
//        $qb = $this->entityManager->createQueryBuilder()
//            ->where('card IN (:cards)')
//            ->setParameter('cards', $cards);
//
//        $query = $qb->getQuery();
//
//        return $query->execute();
    }
}
