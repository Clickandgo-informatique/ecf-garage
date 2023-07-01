<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EntrepriseFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_entreprise', TextType::class, [
                'constraints' => new NotBlank(),
                'label' => 'Nom entreprise'
            ])
            ->add('siren', TextType::class, [
                'constraints' => new NotBlank(),
                'label' => 'SIREN'
            ])
            ->add('gerant', TextType::class, [
                'constraints' => new NotBlank(),
                'label' => 'Gérant(e)'
            ])
            ->add('adresse', TextType::class, [
                'constraints' => new NotBlank(),
                'label' => 'Adresse'
            ])
            ->add('codepostal', TextType::class, [
                'constraints' => new NotBlank(),
                'label' => 'Code postal'
            ])
            ->add('ville', TextType::class, [
                'constraints' => new NotBlank(),
                'label' => 'Ville'
            ])
            ->add('tel1', TextType::class)
            ->add('tel2', TextType::class)
            ->add('mail_principal', EmailType::class, [
                'constraints' => new NotBlank(),
                'label' => 'Mail principal',
                'required' => true
            ])
            ->add('mail_secondaire', EmailType::class, [
                'label' => 'Mail secondaire'
            ])
            ->add('Enregistrer', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary btn-centered']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
