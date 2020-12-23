<?php


namespace App\Controller\Main;

use App\Entity\UserMonobankToken;
use App\Entity\UserPrivatToken;
use App\Form\UserMonobankTokenType;
use App\Form\UserPrivatTokenType;
use App\Repository\UserMonobankTokenRepositoryInterface;
use App\Repository\UserPrivatTokenRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserSettingsKeysController extends BaseController {

    /**
     * @var UserMonobankTokenRepositoryInterface
     */
    private $userMonobankTokenRepository;

    /**
     * @var UserPrivatTokenRepositoryInterface
     */
    private $userPrivatTokenRepository;

    public function __construct(UserMonobankTokenRepositoryInterface $userMonobankTokenRepository, UserPrivatTokenRepositoryInterface $userPrivatTokenRepository) {
        $this->userMonobankTokenRepository = $userMonobankTokenRepository;
        $this->userPrivatTokenRepository = $userPrivatTokenRepository;
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

        $userPrivatToken = $this->userPrivatTokenRepository->getToken($this->getUser());

        if(!$userPrivatToken) {
            $userPrivatToken = new UserPrivatToken();
            $userPrivatToken->setUser($this->getUser());
            $em->persist($userPrivatToken);
        }

        $formPrivatToken = $this->createForm(UserPrivatTokenType::class, $userPrivatToken);
        $formPrivatToken->handleRequest($request);

        if($formMonobankToken->isSubmitted() && $formMonobankToken->isValid()) {
            if($formMonobankToken->get('save')->isClicked()) {
                $this->addFlash('success', 'Токен monobank обновлен');
            }

            $em->flush();
            return $this->redirectToRoute('user_settings_keys');
        }

        if($formPrivatToken->isSubmitted() && $formPrivatToken->isValid()) {
            if($formPrivatToken->get('save')->isClicked()) {
                $this->addFlash('success', 'Токен privatBank обновлен');
            }

            $em->flush();
            return $this->redirectToRoute('user_settings_keys');
        }

        $forRender = parent::renderDefault();
        $forRender['title'] = 'Ключи доступа';

        $forRender['formMonobankToken'] = $formMonobankToken->createView();
        $forRender['formPrivatToken'] = $formPrivatToken->createView();

        return $this->render('main/settings/keys.html.twig', $forRender);
    }
}