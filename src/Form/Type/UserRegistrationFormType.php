<?php

namespace App\Form\Type;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

/**
 * Form de sign up
 */
class UserRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class, ["attr" => [
                "class" => "form-group form-control"]
            ])
            
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                "label" => "Mot de passe",
                'constraints' => [
                    new NotBlank([
                        'message' => 'veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit faire minimum 6  charactères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                "attr" => [
                    "class" => "form-group form-control"
                ],
            ])->add('firstname', TextType::class, [
                "label" => "Prénom",
                "attr" => [
                    "class" => "form-group form-control"
                ]
            ])->add('lastname', TextType::class, [
                "label" => "Nom",
                "attr" => [
                    "class" => "form-group form-control"
                ]
            ])->add('gender', ChoiceType::class, [
                "choices" => [
                    'Homme' => 'male',
                    "Femme" => 'female'
                ],
                "label" => "Genre",
                "attr" => [
                    "class" => "form-group form-control"
                ]
            ])->add('birthdate', BirthdayType::class, [
                "label" => "date de naissance",
                "attr" => [
                    "class" => "form-group form-control"
                ],
                "widget" => "single_text"
            ])->add('jobLove', TextType::class, [
                "label" => "Job de rêve",
                "attr" => [
                    "class" => "form-group form-control"
                ]
            ])->add('adress', IntegerType::class, [
                "label" => "Département",
                "attr" => [
                    "class" => "form-group form-control"
                ]
            ])->add('save', SubmitType::class, [
                "label" => "S'enregistrer",
                "attr" => [
                    "class" => "form-group form-control sign-up-button"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
