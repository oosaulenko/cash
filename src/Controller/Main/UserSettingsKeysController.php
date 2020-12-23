<?php


namespace App\Controller\Main;

use App\Entity\UserMonobankToken;
use App\Form\UserMonobankTokenType;
use App\Repository\UserMonobankTokenRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class UserSettingsKeysController extends BaseController {

    /**
     * @var UserMonobankTokenRepositoryInterface
     */
    private $userMonobankTokenRepository;

    public function __construct(UserMonobankTokenRepositoryInterface $userMonobankTokenRepository ) {
        $this->userMonobankTokenRepository = $userMonobankTokenRepository;
    }

    /**
     * @Route("/settings/keys", name="user_settings_keys")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response {
        $em = $this->getDoctrine()->getManager();

        $userMonobankToken = $this->userMonobankTokenRepository->getToken($this->getUser());

        if(!$userMonobankToken) {
            $userMonobankToken = new UserMonobankToken();
            $userMonobankToken->setUser($this->getUser());
            $em->persist($userMonobankToken);
        }

        $formMonobankToken = $this->createForm(UserMonobankTokenType::class, $userMonobankToken);
        $formMonobankToken->handleRequest($request);

        if($formMonobankToken->isSubmitted() && $formMonobankToken->isValid()) {
            if($formMonobankToken->get('save')->isClicked()) {
                $this->addFlash('success', 'Токен monobank обновлен');
            }

            $em->flush();
            return $this->redirectToRoute('user_settings_keys');
        }

        $forRender = parent::renderDefault();
        $forRender['title'] = 'Ключи доступа';
//        $forRender['user_keys'] = $userMonobankToken;
        $forRender['formMonobankToken'] = $formMonobankToken->createView();

        return $this->render('main/settings/keys.html.twig', $forRender);
    }
}