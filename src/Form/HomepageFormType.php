<?php

namespace App\Form;

use App\Entity\Homepage;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\File;

class HomepageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('logo', FileType::class, [
                'label' => 'Fichier image pour le logo (.gif, .bmp, .jpg, .webp): ',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/gif',
                            'image/bmp',
                            'image/webp'
                        ],
                        'mimeTypesMessage' => "Veuillez choisir uniquement un fichier image ayant l'extension .gif,.jpg,.webp"
                    ])
                ],
            ])  
            ->add('titre_principal', TextType::class, ['constraints' => new NotBlank()])
            ->add('sous_titre', TextType::class, ['label' => 'Sous-titre ou slogan'])
            ->add('description', CKEditorType::class)
   
            ->add('Enregistrer', SubmitType::class, ['attr' => ['class' => 'btn btn-primary btn-centered']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Homepage::class,
        ]);
    }
}
