<?php
namespace App\Form;

use App\Entity\TypesVehicules;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class TypesVehiculesFormType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom_type',TextType::class,[
            'label'=>'Type de véhicule',
            'constraints'=>new NotBlank()
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TypesVehicules::class,
        ]);
    }
}