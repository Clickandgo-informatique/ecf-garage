<?php

namespace App\Form;

use App\Entity\Motorisations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class MotorisationsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nommotorisation', TextType::class, [

                'label' => 'Motorisation : ',new NotBlank(['message'=>"Veuillez spécifier le nom d'une motorisation."])
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Motorisations::class,
        ]);
    }
}
