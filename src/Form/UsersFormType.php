<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UsersFormType extends AbstractType
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
            ->add('roles', ChoiceType::class, [
                'required'=>true,
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Employé' => 'ROLE_EMPLOYEE',
                    'Administrateur' => 'ROLE_ADMIN'
                ], 'expanded' => true, 'multiple' => true,
                'label' => "Rôles : ",
                'attr' => ['class' => ' form-control liste-roles']
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'constraints' => new Regex(
                    pattern: '^$S*(?=S{8,})(?=S*[a-z])(?=S*[A-Z])(?=S*[d])(?=S*[W])S*$',
                    match: true,
                    message: "Votre mot de passe doit comporter au moins huit caractères, dont des lettres majuscules et minuscules,ne pas contenir d'espace, et au moins un chiffre et un symbole !@#$%&*()-+=^."
                ),
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('adresse', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('code_postal', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('ville', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('tel_fixe', TelType::class, [
                'constraints' => new Regex(pattern: '#(0|\+33)[1-9]( *[0-9]{2}){4}#', message: 'Le numéro de télephone fixe renseigné est incorrect, merci de le vérifier à nouveau.'),
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('tel_mobile', TelType::class, [
                'constraints' => new Regex(pattern: '#(0|\+33)[1-9]( *[0-9]{2}){4}#', message: 'Le numéro de télephone fixe renseigné est incorrect, merci de le vérifier à nouveau.'),
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('created_at', DateTimeType::class, [
                'label' => 'Créée le : ',
                'widget' => 'single_text',
                'disabled' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
