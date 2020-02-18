<?php

namespace App\Controller\RecruiterController;

use App\Entity\Recruiter;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Type\RecruiterRegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/recruiter")
 */
class RecruiterRegistrationController extends AbstractController
{

   /**
    * @Route("/sign", name="recruiter_sign")
    */
    public function recruiterSignDispatch(){

        return $this->render("recruiter/dispatch_sign.html.twig");
    }

/**
     * @Route("/register", name="recruiter_register")
     * Route de Sign Up
     */
    public function recruiterRegister(Request $request, UserPasswordEncoderInterface $passwordEncoder,MailerInterface $mailer): Response
    {
        $recruiter = new Recruiter();
        $form = $this->createForm(RecruiterRegistrationFormType::class, $recruiter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $recruiter->setPassword(
                $passwordEncoder->encodePassword(
                    $recruiter,
                    $form->get('plainPassword')->getData()
                )
            );
            $email = (new Email())
            ->from('v.labarthe@gmail.com')
            ->to($recruiter->getEmail())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Job-Tinder')
            ->text('Votre compte recruiter a bien été créé');
        $mailer->send($email);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($recruiter);
            $entityManager->flush(); 
               
            $this->addFlash(
                'success',
                'Votre compte a bien été crée'
            );

            // do anything else you need here, like send an email

            return $this->redirectToRoute("recruiter_login",);
        }
        

        return $this->render("recruiter/sign_up.html.twig", [
            "formView" => $form->createView(),
            
        ]);
    }

     /**
     * @Route("/login", name="recruiter_login")
     * Route de Sign In 
     */
    public function recruiterLogin(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render("recruiter/login.html.twig",[
        'last_username' => $lastUsername,
        'error' => $error
        ]);
    }
    
}