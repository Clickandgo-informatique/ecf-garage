<?php

namespace App\Form;

use App\Entity\Clients;
use App\Entity\Couleurs;
use App\Entity\Marques;
use App\Entity\Vehicules;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('modele')
            ->add('motorisation')
            ->add('cylindree')
            ->add('nb_portes')
            ->add('prix_vente')
            ->add('date_mise_en_circulation')
            ->add('nb_places')
            ->add('date_mise_en_vente')
            ->add('type_vehicule')
            ->add('boite')
            ->add('num_chassis')
            ->add('localisation')
            ->add('date_vente')
            ->add('critere_pollution')
            ->add('date_controle_technique')
            ->add('remarques')
            ->add('kilometrage')
            ->add('nb_proprietaires')
            ->add('chevaux_fiscaux')
            ->add('chevaux_din')
            ->add('reference_interne')
            ->add('plaque_immatriculation')
            ->add('publication_annonce')
            ->add('marque', EntityType::class, [
                'class' => Marques::class
            ])
            ->add('proprietaire',EntityType::class,[
                'class'=>Clients::class
            ])
            ->add('favoris')
            ->add('couleur', EntityType::class, [
                'class' => Couleurs::class
            ])
            
            ->add('photos',FileType::class,[
                'label'=>false,
                'multiple'=>true,
                'mapped'=>false,
                'required'=>false
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vehicules::class,
        ]);
    }
}
