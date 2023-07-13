<?php

namespace App\Form;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class FormContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Votre nom :',
                'constraints' => new NotBlank(),
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Votre prénom :',
                'constraints' => new NotBlank(),
                'attr' => [
                    'class' => 'form-control',
                ]
            ])

            ->add('subject', TextType::class, [
                'label' => "Objet : ",
                'constraints' => new NotBlank(),
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Décrivez-ici votre demande'
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre e-mail :',
                'constraints' => new NotBlank(),
                'attr' => ['class' => 'form-control', 'placeholder' => 'Votre email est obligatoire !'],

            ])
            ->add('message', CKEditorType::class, [
                'label' => 'Votre message + coordonnées de contact + données du véhicule concerné : ',
                'constraints' => new NotBlank(),
                'attr' => ['class' => 'form-control'],
            ])
            ->add('telContact', TelType::class)
            ->add('Envoyer', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary btn-centered']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
