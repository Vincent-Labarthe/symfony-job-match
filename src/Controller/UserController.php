<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/applicant/login", name="applicant_login")
     */
    public function candidateSignUp(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

        $newUser = new User();

        $formBuilder = $this->createFormBuilder($newUser);

        $formBuilder->add('firstname', TextType::class, [
            "label" => "Prénom",
            "attr" => [
                "class" => "form-group form-control"
            ]
        ]);

        $formBuilder->add('lastname', TextType::class, [
            "label" => "Nom",
            "attr" => [
                "class" => "form-group form-control"
            ]
        ]);

        $formBuilder->add('gender', ChoiceType::class, [
            "choices" => [
                'Homme' => 'male',
                "Femme" => 'female'
            ],
            "label" => "Genre",
            "attr" => [
                "class" => "form-group form-control"
            ]
        ]);

        $formBuilder->add('email', EmailType::class, [
            "label" => "email",
            "attr" => [
                "class" => "form-group form-control"
            ]
        ]);

        $formBuilder->add(
            'plainPassword',
            RepeatedType::class,
            array(
                "type" => PasswordType::class,
                'first_options' => array(
                    'label' => 'Mot de passe', "attr" => [
                        "class" => "form-group form-control"
                    ]
                ),
                'second_options' => array(
                    'label' => 'Repetez mot de passe',   "attr" => [
                        "class" => "form-group form-control"
                    ]
                ),
            ),
        );


        $formBuilder->add('birthdate', BirthdayType::class, [
            "label" => "date de naissance",
            "attr" => [
                "class" => "form-group form-control"
            ],
            "widget" => "single_text"
        ]);

        $formBuilder->add('jobLove', TextType::class, [
            "label" => "Jod de rêve",
            "attr" => [
                "class" => "form-group form-control"
            ]
        ]);

        $formBuilder->add('save', SubmitType::class, [
            "label" => "S'enregistrer",
            "attr" => [
                "class" => "form-group form-control sign-up-button"
            ]
        ]);

        $form = $formBuilder->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $password= $passwordEncoder->encodePassword($newUser, $newUser->getPlainPassword());
            $newUser->setPlainPassword($password);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($newUser);
            $manager->flush();
            $this->addFlash("success", "Votre compte a bien été créé");

            return $this->redirectToRoute("applicant_login");
        }

        return $this->render("user/login.html.twig", [
            "formView" => $form->createView()
        ]);
    }
}
