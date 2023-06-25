<?php

namespace App\Form;

use App\Entity\Services;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('service', EntityType::class, [
                'class' => Services::class,
                'label' => 'Service contacté : ',
            ])
            ->add('mail',EmailType::class)
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            
        ]);
    }
}
