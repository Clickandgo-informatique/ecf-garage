<?php

namespace App\Form;

use App\Entity\Boites;
use App\Entity\Clients;
use App\Entity\Couleurs;
use App\Entity\Marques;
use App\Entity\Motorisations;
use App\Entity\Vehicules;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('modele',TextType::class)
            ->add('motorisation', EntityType::class, ['class' => Motorisations::class])
            ->add('cylindree', NumberType::class)
            ->add('nb_portes', NumberType::class)
            ->add('prix_vente', NumberType::class)
            ->add('date_mise_en_circulation', DateType::class, ['widget' => 'single_text'])
            ->add('nb_places', NumberType::class)
            ->add('date_mise_en_vente', DateType::class, ['widget' => 'single_text'])
            ->add('type_vehicule')
            ->add('boite', EntityType::class,['class'=>Boites::class])
            ->add('num_chassis')
            ->add('localisation')
            ->add('date_vente', DateType::class, ['widget' => 'single_text','required'=>false])
            ->add('critere_pollution', NumberType::class)
            ->add('date_controle_technique', DateType::class, ['widget' => 'single_text'])
            ->add('remarques')
            ->add('kilometrage', NumberType::class)
            ->add('nb_proprietaires', NumberType::class)
            ->add('chevaux_fiscaux', NumberType::class)
            ->add('chevaux_din', NumberType::class)
            ->add('reference_interne',TextType::class)
            ->add('plaque_immatriculation',TextType::class)
            ->add('publication_annonce')
            ->add('marque', EntityType::class, [
                'class' => Marques::class
            ])
            ->add('proprietaire', EntityType::class, [
                'class' => Clients::class
            ])
            ->add('couleur', EntityType::class, [
                'class' => Couleurs::class
            ])

            ->add('photos', FileType::class, [
                'label' => false,
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicules::class,
        ]);
    }
}
