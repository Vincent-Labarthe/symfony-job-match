<?php
namespace App\Form\Type;

use App\Entity\JobApplication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class JobApplicationType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $builder->add('title', TextType::class, [
            "label" => "Titre de l'annonce",
            "attr" => [
                "class" => "form-group form-control"
            ]
        ])->add('description', TextType::class, [
            "label" => "Description du poste",
            "attr" => [
                "class" => "form-group form-control"
            ]
        ])->add('adress', IntegerType::class, [
            "label" => "Département",
            "attr" => [
                "class" => "form-group form-control"
            ]
        ])->add('save', SubmitType::class, [
            "label" => "Déposer l'annonce",
            "attr" => [
                "class" => "form-group form-control sign-up-button"
            ]
        ])
    ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => JobApplication::class,
        ]);
    }
} 