<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\UserChangePasswordType;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController {
    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils) : Response {
//         if ($this->getUser()) {
//             return $this->redirectToRoute('target_path');
//         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/sign_up", name="sign_up")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     *
     * @return RedirectResponse|Response
     */
    public function sign_up(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);

        if ( ($form->isSubmitted()) && ($form->isValid()) ) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRoles(["ROLE_ADMIN"]);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('admin_user');
        }

        $forRender = [];
        $forRender['title'] = 'Регистрация пользователя';
        $forRender['form'] = $form->createView();
        return $this->render('security/sign_up.html.twig', $forRender);
    }

    /**
     * @Route("/settings/security", name="user_settings_security")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     *
     * @return RedirectResponse|Response
     */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $passwordEncoder) {

        $user = $this->getUser();

        $form = $this->createForm(UserChangePasswordType::class);
        $em = $this->getDoctrine()->getManager();
        $form->handleRequest($request);

        if ( ($form->isSubmitted()) && ($form->isValid()) ) {

            $old_password = $passwordEncoder->isPasswordValid($user, $form->get('oldPassword')->getData());

            if ( $old_password == false ) {
                $this->addFlash('danger', 'Старый пароль не совпадает');
            } else {
                $password = $passwordEncoder->encodePassword($user, $form->get('plainPassword')->getData());
                $user->setPassword($password);
                $em->persist($user);
                $em->flush();

                $this->addFlash('success', 'Пароль обновлен');
            }

            if ( !$form->isValid() ) {
                $this->addFlash('danger', 'Пароли не совпадают');
            }

            return $this->redirectToRoute('user_settings_security');
        }

        $forRender = [];
        $forRender['title'] = 'Безопасность';
        $forRender['type'] = 'security';
        $forRender['form'] = $form->createView();

        return $this->render('main/settings/security.html.twig', $forRender);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout() {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
