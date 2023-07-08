<?php

namespace App\Form;

use App\Entity\Clients;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ClientsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir une adresse email valide.'
                    ])
                ],
                'required' => true,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('nom', TextType::class, [
                'constraints' => new NotBlank()
            ])
            ->add('prenom', TextType::class)
            ->add('adresse', TextType::class)
            ->add('code_postal', TextType::class, ['constraints' => new Regex(pattern: '#^[0-9]{5}$#', message: "Le code postal inséré est incorrect, un code postal français doit contenir uniquement 5 chiffres...")])
            ->add('ville', TextType::class)
            ->add('telephonefixe', TelType::class, [
                'label' => 'Telephone fixe',
                'constraints' => new Regex(pattern: '#(0|\+33)[1-9]( *[0-9]{2}){4}#', message: 'Le numéro de télephone fixe renseigné est incorrect, merci de le vérifier à nouveau.'),
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('telephonemobile', TelType::class, [
                'label' => 'Telephone mobile',
                'constraints' => new Regex(pattern: '#(0|\+33)[1-9]( *[0-9]{2}){4}#', message: 'Le numéro de télephone mobile renseigné est incorrect, merci de le vérifier à nouveau.'),
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('created_at', DateTimeType::class, [
                'label' => 'Créée le : ',
                'widget' => 'single_text',
                'disabled' => true,
                'attr' => ['class' => 'created_at form-control']

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Clients::class,
        ]);
    }
}
