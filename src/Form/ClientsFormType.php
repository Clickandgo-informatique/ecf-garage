<?php

namespace App\Form;

use App\Entity\Clients;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')     
            ->add('nom')
            ->add('prenom')
            ->add('adresse')
            ->add('code_postal')
            ->add('ville')
            ->add('telephone_fixe')
            ->add('telephone_mobile')
            ->add('created_at', DateTimeType::class, [
                'label' => 'Créée le : ',
                'widget' => 'single_text',
                'disabled' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Clients::class,
        ]);
    }
}
