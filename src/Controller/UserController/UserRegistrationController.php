<?php

namespace App\Controller\UserController;

use App\Entity\User;

use Symfony\Component\Mime\Email;
use App\Form\Type\UserRegistrationFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/user")
 */
class UserRegistrationController extends AbstractController
{

    /**
     * @Route("/sign", name="user_sign")
     * Route affichant le template du dispatch signIn/Up
     */
    public function userSignDispatch()
    {

        return $this->render("user/dispatch_sign.html.twig");
    }

    /**
     * @Route("/register", name="user_register")
     * Route de Sign Up
     */
    public function userRegister(Request $request, UserPasswordEncoderInterface $passwordEncoder, MailerInterface $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(UserRegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );/*
            $email = (new Email())
                ->from('v.labarthe@gmail.com')
                ->to($user->getEmail())
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject('Job-Tinder')
                ->text('Votre compte candidat a bien été créé');
            $mailer->send($email);*/

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Votre compte a bien été crée'
            );

            // do anything else you need here, like send an email

            return $this->redirectToRoute("user_login",);
        }


        return $this->render("user/sign_up.html.twig", [
            "formView" => $form->createView(),

        ]);
    }

    /**
     * @Route("/login", name="user_login")
     * Route de Sign In 
     */
    public function userLogin(AuthenticationUtils $authenticationUtils )
    {
        //méthode permettant de rediriger l'utilisateur vers sa home page si déjà connecté
        if($this->getUser()) {
            $user= $this->getUser();
            return $this->redirectToRoute('user_page', ['id' => $user->getId()]);
        }
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render("user/login.html.twig", [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }
}
