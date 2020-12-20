<?php


namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;

class AdminHomeController extends AdminBaseController {

    /**
     * @Route("/admin", name="admin_home")
     */
    public function index() {

        $for_render = parent::renderDefault();

        return $this->render('admin/index.html.twig', $for_render);
    }
}