<?php


namespace App\Controller\Main;

use App\Repository\CardRepositoryInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends BaseController {

    /**
     * @var CardRepositoryInterface
     */
    private $cardRepository;

    public function __construct(CardRepositoryInterface $cardRepository) {
        $this->cardRepository = $cardRepository;
    }

    /**
     * @Route("/", name="home")
     */
    public function index() {

        if(!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $forRender = parent::renderDefault();

        $forRender['title'] = 'Главная';
        $forRender['cards'] = $this->cardRepository->getCards($this->getUser());

        return $this->render('main/index.html.twig', $forRender);
    }
}