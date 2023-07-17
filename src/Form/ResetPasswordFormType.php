<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class ResetPasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('password', PasswordTypeType::class, [
                'label' => 'Veuillez indiquer votre mot de passe svp.',
                'attr' => ['class' => 'form-control'],
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
            // Configure your form options here
        ]);
    }
}
