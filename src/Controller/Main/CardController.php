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
            $em->persist($card);
            $em->flush();
            $this->addFlash('success', 'Карта успешно добавлена');
            return $this->redirectToRoute('cards');
        }

        $for_render = parent::renderDefault();
        $for_render['title'] = 'Добавить карту';
        $for_render['form'] = $form->createView();

        return $this->render('admin/card/form.html.twig', $for_render);
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
            $card->setBank('monobank');
            $card->setKeyCard($account->id());
            $card->setCurrency($account->currencyCode());
            $em->persist($card);
            $em->flush();
        }

        return $this->redirectToRoute('cards');
    }


}