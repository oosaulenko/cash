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


    private $paramsTransaction;


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

    public function getTransactions($cards)
    {
        $query = $this->createQueryBuilder('t')
            ->where('t.card IN (:cards)')
            ->setParameter('cards', $cards);

        $this->setFilterParams($query);

        return $query
            ->getQuery()
            ->execute()
            ;
    }

    public function getIncome($cards)
    {
        $query = $this->createQueryBuilder('t')
            ->select('SUM(t.amount)')
            ->where('t.card IN (:cards)')
            ->andWhere('t.amount >= 0')
            ->setParameter('cards', $cards);

        $this->setFilterParams($query);

        return round($query
            ->getQuery()
            ->getSingleScalarResult(), 2)
            ;
    }

    public function getExpense($cards)
    {
        $query = $this->createQueryBuilder('t')
            ->select('SUM(t.amount)')
            ->where('t.card IN (:cards)')
            ->andWhere('t.amount < 0')
            ->setParameter('cards', $cards);

        $this->setFilterParams($query);

        return round($query
            ->getQuery()
            ->getSingleScalarResult(), 2)
            ;
    }

    public function setParams($params)
    {
        $this->paramsTransaction = $params;

        return $this;
    }

    public function setFilterParams($query)
    {
        if(!empty($this->paramsTransaction['sort'])) $query->orderBy('t.time', $this->paramsTransaction['sort']);

        if(empty($this->paramsTransaction['typeIncome']) || empty($this->paramsTransaction['typeExpense'])){
            if(!empty($this->paramsTransaction['typeIncome'])) $query->andWhere('t.amount >= 0');
            if(!empty($this->paramsTransaction['typeExpense'])) $query->andWhere('t.amount < 0');
        }

        if(!empty($this->paramsTransaction['category'])) $query->andWhere('t.category IN (:category)')->setParameter('category', $this->paramsTransaction['category']);

        if(!empty($this->paramsTransaction['timeFrom'])) $query->andWhere('t.time >= (:timeFrom)')->setParameter('timeFrom', Carbon::parse($this->paramsTransaction['timeFrom'], 'Europe/Kiev')->startOfDay()->getTimestamp());
        if(!empty($this->paramsTransaction['timeTo'])) $query->andWhere('t.time <= (:timeTo)')->setParameter('timeTo', Carbon::parse($this->paramsTransaction['timeTo'], 'Europe/Kiev')->endOfDay()->getTimestamp());

        if(!empty($this->paramsTransaction['amountFrom'])) $query->andWhere('t.amount >= (:amountFrom)')->setParameter('amountFrom', $this->paramsTransaction['amountFrom']);
        if(!empty($this->paramsTransaction['amountTo'])) $query->andWhere('t.amount <= (:amountTo)')->setParameter('amountTo', $this->paramsTransaction['amountTo']);


    }
}
