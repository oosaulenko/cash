<?php


namespace App\Controller\Main;

use Symfony\Component\Routing\Annotation\Route;

class UserSettingsController extends BaseController {

    /**
     * @Route("/settings", name="user_settings")
     */
    public function index() {

        if(!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $forRender = parent::renderDefault();
        $forRender['title'] = 'Настройки профиля';

        return $this->render('main/settings/index.html.twig', $forRender);
    }
}