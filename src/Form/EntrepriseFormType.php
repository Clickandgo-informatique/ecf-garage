<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

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
                'constraints' => new Regex(pattern: '#^[0-9]{5}$#', message: "Le code postal inséré est incorrect, un code postal français doit contenir uniquement 5 chiffres..."),
                'label' => 'Code postal'
            ])
            ->add('ville', TextType::class, [
                'constraints' => new NotBlank(),
                'label' => 'Ville'
            ])
            ->add(
                'tel1',
                TelType::class,
                ['constraints' => new Regex(pattern: '#(0|\+33)[1-9]( *[0-9]{2}){4}#', message: 'Le numéro de télephone fixe renseigné est incorrect, merci de le vérifier à nouveau.')],
            )
            ->add(
                'tel2',
                TelType::class,
                ['constraints' => new Regex(pattern: '#(0|\+33)[1-9]( *[0-9]{2}){4}#', message: 'Le numéro de télephone fixe renseigné est incorrect, merci de le vérifier à nouveau.')],
            )
            ->add('mail_principal', EmailType::class, [
                'constraints' => new NotBlank(['message' => 'Le champ de mail principal est obligatoire.']),
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
