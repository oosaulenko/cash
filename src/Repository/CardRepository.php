<?php

namespace App\Repository;

use App\Entity\Card;
use App\Entity\Transaction;
use Carbon\Carbon;
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

    /**
     * @var UserMonobankTokenRepositoryInterface
     */
    private $userMonobankTokenRepository;

    /**
     * @var CategoryMccRepositoryInterface
     */
    private $categoryMccRepository;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @var TransactionRepositoryInterface
     */
    private $transactionRepository;

    public function __construct(ManagerRegistry $registry,
                                EntityManagerInterface $entityManager,
                                TokenStorageInterface $user,
                                UserMonobankTokenRepositoryInterface $userMonobankTokenRepository,
                                CategoryMccRepositoryInterface $categoryMccRepository,
                                CategoryRepositoryInterface $categoryRepository,
                                TransactionRepositoryInterface $transactionRepository
    ) {
        parent::__construct($registry, Card::class);
        $this->entityManager = $entityManager;
        $this->user = $user;
        $this->userMonobankTokenRepository = $userMonobankTokenRepository;
        $this->categoryMccRepository = $categoryMccRepository;
        $this->categoryRepository = $categoryRepository;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * @param int $cardId
     * @return mixed|object|null
     */
    public function getOne(int $cardId): ?object {
        return parent::find($cardId);
    }

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

        try {
            $monobank = new Monobank($token);
        } catch(InternalErrorException $e) {
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

    /**
     * @param $currency
     * @return string
     */
    public function getCurrencyCard($currency): string {

        switch($currency) {
            case '980':
                $currency_name = 'UAH';
                break;

            case '840':
                $currency_name = 'USD';
                break;

            case '978':
                $currency_name = 'EUR';
                break;

            case '985':
                $currency_name = 'PLN';
                break;

            default:
                $currency_name = 'UAH';
        }

        return $currency_name;
    }

    /**
     * @param $token
     * @param $keyCard
     * @param $from
     * @param $to
     * @return mixed|string
     */
    public function getCardTransactions($token, $keyCard, $from, $to) {

        try {
            $monobank = new Monobank($token);
        } catch(InternalErrorException $e) {
            return $e->getMessage();
        }

        try {
            return $monobank->personal->getStatement($keyCard, $from, $to)->statements();
        } catch(InternalErrorException $e) {
            return $e->getMessage();
        } catch(InvalidAccountException $e) {
            return $e->getMessage();
        } catch(MonobankException $e) {
            return $e->getMessage();
        } catch(TooManyRequestsException $e) {
            return [
                'code'    => 521,
                'message' => 'Большое количество запросов',
                'test'    => $e->getCode()
            ];
        } catch(UnknownTokenException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param $user
     * @return array
     */
    public function getCardsMonobank($user): array {
        return parent::findBy([
            'user'   => $user,
            'status' => 1,
            'bank'   => 'Monobank'
        ], ['time_update' => 'ASC']);
    }

    /**
     * @param $user
     * @return mixed|void
     */
    public function updateMonobankTransactions($user) {
        $cards = $this->getCardsMonobank($user);

        foreach($cards as $card) {
            $from = Carbon::createFromTimestamp($card->getTimeUpdate());
            $to = Carbon::createFromTimestamp($card->getTimeUpdate())->addDays(30);
            $transactions = $this->getCardTransactions($this->userMonobankTokenRepository->getTokenID($user), $card->getKeyCard(), $from, $to);

            dump(count($transactions));

            if(empty($transactions['code'])) {
                $this->updateTime($card, $to->getTimestamp());

                foreach($transactions as $transaction) {
                    $checkTransaction = $this->entityManager->getRepository(Transaction::class)->findOneBy([
                        'code' => $transaction->id()
                    ]);

                    if(empty($checkTransaction)) {
                        $this->transactionRepository->create($transaction, $card);
                    }
                }
            }
        }

    }

    /**
     * @param Card $card
     * @param int $time
     * @return Card
     */
    public function updateTime(Card $card, int $time): Card {
        $card->setTimeUpdate($time);
        $this->entityManager->persist($card);
        $this->entityManager->flush();

        return $card;
    }

    public function getCardsID($user): array
    {

        //        $query = $qb->execute();
//        $query = $qb->getParameters();
        return $this->createQueryBuilder('c')
            ->select('c.id')
            ->where('c.user = (:user)')
            ->setParameter('user', $user)
            ->getQuery()
            ->execute();
    }
}
