<?php


namespace App\Controller\Main;


use App\Entity\Card;
use App\Form\CardType;
use App\Repository\CardRepositoryInterface;
use App\Repository\UserMonobankTokenRepositoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends BaseController {

    /**
     * @var CardRepositoryInterface
     */
    private $cardRepository;

    /**
     * @var UserMonobankTokenRepositoryInterface
     */
    private $userMonobankTokenRepository;

    public function __construct(CardRepositoryInterface $cardRepository, UserMonobankTokenRepositoryInterface $userMonobankTokenRepository) {
        $this->cardRepository = $cardRepository;
        $this->userMonobankTokenRepository = $userMonobankTokenRepository;
    }

    /**
     * @Route("/cards", name="cards")
     */
    public function index(): Response {
        $forRender = parent::renderDefault();

        if($this->userMonobankTokenRepository->getToken($this->getUser())) {
            $forRender['monobank_token'] = 1;
        }

        $forRender['title'] = 'Баланс';
        $forRender['cards'] = $this->cardRepository->getCards($this->getUser());

        return $this->render('main/card/index.html.twig', $forRender);
    }


    /**
     * @Route("/card/add", name="card_add")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function create(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $card = new Card();
        $form = $this->createForm(CardType::class, $card);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $card->setCreateAtValue();
            $card->setUpdateAtValue();
            $card->setUser($this->getUser());
            $card->setBalance(0);
            $card->setStatus(1);
            $em->persist($card);
            $em->flush();
            $this->addFlash('success', 'Карта успешно добавлена');
            return $this->redirectToRoute('cards');
        }

        $forRender = parent::renderDefault();
        $forRender['title'] = 'Добавить карту';
        $forRender['form'] = $form->createView();

        return $this->render('main/card/add.html.twig', $forRender);
    }

    /**
     * @Route("/card/update/{cardId}", name="card_update")
     * @param int $cardId
     * @param Request $request
     * @return Response
     */
    public function update(int $cardId, Request $request): Response {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Редактировать карту';

        $em = $this->getDoctrine()->getManager();

        $card = $this->cardRepository->getOne($cardId);
        $form = $this->createForm(CardType::class, $card);
        $form->remove('bank');
        $form->remove('currency');

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($card);
            $em->flush();

            $this->addFlash('success', 'Карта обновлена');
            return $this->redirectToRoute('cards');
        }

        $forRender['form'] = $form->createView();

        return $this->render('main/card/update.html.twig', $forRender);
    }

    /**
     * @Route("/card/list_all_cards_monobank", name="list_all_cards_monobank")
     */
    public function listAllCardMonobank(): Response {

        $accounts = $this->cardRepository->getListCardMonobankAPI($this->userMonobankTokenRepository->getTokenID($this->getUser()));

        foreach($accounts as $account) {
            $em = $this->getDoctrine()->getManager();
            $card = new Card();
            $card->setName('Без названия');
            $card->setCreateAtValue();
            $card->setUpdateAtValue();
            $card->setUser($this->getUser());
            $card->setBalance($account->balance() / 100);
            $card->setBank('Monobank');
            $card->setKeyCard($account->id());
            $card->setCurrency($this->cardRepository->getCurrencyCard($account->currencyCode()));
            $em->persist($card);
            $em->flush();
        }

        return $this->redirectToRoute('cards');
    }

    /**
     * @Route("/card/status/{cardId}", name="card_status")
     * @param int $cardId
     * @param Request $request
     * @return Response
     */
    public function status(int $cardId, Request $request): Response {
        $em = $this->getDoctrine()->getManager();

        $card = $em->getRepository(Card::class)->findOneBy([
            'id' => $cardId
        ]);

        $card->setStatus(($card->getStatus()) ? 0 : 1);

        if($card->getStatus()) {
            $this->addFlash('success', 'Карта разблокирована');
        } else {
            $this->addFlash('warning', 'Карта заблокирована');
        }

        $em->persist($card);
        $em->flush();

        return $this->redirectToRoute('cards');
    }


    /**
     * @Route("/{id}", name="card_delete", methods="DELETE")
     * @param Request $request
     * @param Card $card
     * @return Response
     */
    public function delete(Request $request, Card $card): Response {

        if($this->isCsrfTokenValid('delete' . $card->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($card);
            $em->flush();
            $this->addFlash('danger', 'Карта удаленна');
        }

        return $this->redirectToRoute('cards');
    }


}