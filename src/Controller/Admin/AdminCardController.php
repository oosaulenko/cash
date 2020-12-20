<?php


namespace App\Controller\Admin;

use App\Entity\Card;
use App\Form\CardType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminCardController extends AdminBaseController {

    /**
     * @Route("/admin/card", name="admin_card")
     */
    public function index() {
        $for_render = parent::renderDefault();

        $cards = $this->getDoctrine()->getRepository(Card::class)->findBy([
            'user' => $this->getUser()
        ]);

        $for_render['title'] = 'Список карт';
        $for_render['cards'] = $cards;

        return $this->render('admin/card/index.html.twig', $for_render);
    }


    /**
     * @Route("/admin/card/create", name="admin_card_create")
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
            return $this->redirectToRoute('admin_card');
        }

        $for_render = parent::renderDefault();
        $for_render['title'] = 'Добавить карту';
        $for_render['form'] = $form->createView();

        return $this->render('admin/card/form.html.twig', $for_render);
    }
}