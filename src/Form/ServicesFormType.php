<?php

namespace App\Form;

use App\Entity\Services;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServicesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom du service'
            ])
            ->add('resume', TextType::class, [
                'label' => 'Résumé à afficher'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description détaillée du service'
            ])
            ->add('prix_a_partir_de', MoneyType::class, [
                'label' => 'Prix ("A partir de ...") à afficher en euros',
                'attr' => [
                    'class' => 'price'
                ]
            ])
            ->add('telephone_1',TelType::class,[
                'label'=>'Telephone 1'
            ])
            ->add('telephone_2',TelType::class,[
                'label'=>'Telephone 2'
            ])
            ->add('mail_service_1',EmailType::class,['label'=>'Email 1'])
            ->add('mail_service_2',EmailType::class,['label'=>'Email 2'])
            ->add('civilite_responsable',TextType::class,['label'=>'Civilité'])
            ->add('responsable',TextType::class,['label'=>'Responsable'])
            ->add('icone', TextType::class)
            ->add('Enregistrer', SubmitType::class,[
                'attr'=>['class'=>'btn btn-primary btn-centered']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Services::class,
        ]);
    }
}
