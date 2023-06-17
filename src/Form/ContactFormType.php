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
use Symfony\Component\Validator\Constraints\NotBlankValidator;
use Symfony\Component\Validator\Constraints\NotNull;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('service', EntityType::class, [
                'class' => Services::class,
                'label' => 'Service contacté :',
            ])
            ->add('subject', TextType::class, [
                'label' => "Objet :",
                'disabled' => true,
                'attr' => ['class' => 'form-control'],
                'constraints' => new NotBlank(), new NotNull()

            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre e-mail',
                'attr' => ['class' => 'form-control'],
                'constraints' => new NotBlank(), new NotNull()
            ])
            ->add('message', CKEditorType::class, [
                'label' => 'Votre message',
                'constraints' => new NotBlank(), new NotNull()
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
