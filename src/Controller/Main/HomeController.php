<?php


namespace App\Controller\Main;

use Symfony\Component\Routing\Annotation\Route;

class HomeController extends BaseController {

    /**
     * @Route("/", name="home")
     */
    public function index() {

        if(!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $for_render = parent::renderDefault();

        return $this->render('main/index.html.twig', $for_render);
    }
}