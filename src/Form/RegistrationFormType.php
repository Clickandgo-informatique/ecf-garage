<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control'
                ], 'label' => 'E-mail'
            ])
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ], 'label' => 'Nom'
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ], 'label' => 'Prénom'
            ])
            ->add('adresse', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ], 'label' => 'Adresse'
            ])
            ->add('code_postal', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ], 'label' => 'Code postal'
            ])
            ->add('ville', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ], 'label' => 'Ville'
            ])
            ->add('RGPDConsent', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'J\'accepte les conditions.',
                    ]),
                ], 'label' => 'J\'accepte les conditions d\'utilisation.'
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'form-control'
                ],
                'label' => 'Mot de passe',
                'constraints' => new Regex(
                    pattern: '/\A(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%&*()+=^.-])\S{8,}\z/',
                    match: true,
                    message: "Votre mot de passe doit comporter au moins huit caractères, dont des lettres majuscules et minuscules, au moins un chiffre et un symbole '!,-,?,/ ect...'."
                ),      
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
