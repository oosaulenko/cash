<?php


namespace App\Controller\Main;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransactionController extends BaseController {

    /**
     * @Route("/transactions", name="transactions")
     */
    public function index(): Response {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Транзакции';
        $forRender['transactions'] = '';

        return $this->render('main/transaction/index.html.twig', $forRender);
    }

}