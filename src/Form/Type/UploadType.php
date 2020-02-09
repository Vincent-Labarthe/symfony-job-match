<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Form pour modifier image de profil
 */
class UploadType  extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ...
            ->add('profilPicture', FileType::class, [
                'label' => 'Sélectionner une image',

                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypesMessage' => 'Merci de charger une image valide',
                    ])
                ],
            ])->add(
                'save',
                SubmitType::class,
                [
                    "label" => "Ajouter"
                ]
            );
    }
}
