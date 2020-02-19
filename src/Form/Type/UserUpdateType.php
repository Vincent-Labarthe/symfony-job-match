<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;



class UserUpdateType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'email',
            EmailType::class,
            [
                "attr" => ["class" => "form-group form-control"]
            ]
        )->add('firstname', TextType::class, [
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
        ])->add('skill', ChoiceType::class, [
            "choices" => [
                'HTML5' => 'HTML5',
                "CSS3" => 'CSS3',
                'JS' => 'JS',
                "JQUERY" => 'JQUERY',
                'PHP' => 'PHP',
                "BOOTSTRAP" => 'BOOTSTRAP',
                'AJAX' => 'AJAX',
                "REACT" => 'REACT',
            ],
            "multiple"=>true,
            "label" => "Compétence(s)",
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
                "class" => "form-group form-control sign-up-button",
                 "style"=>"background-color: #BEEDFF"
            ]
        ]);
    }
}
