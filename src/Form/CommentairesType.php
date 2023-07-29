<?php

namespace App\Form;

use App\Entity\Commentaires;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CommentairesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Votre e-mail',
                'attr' => ['class' => 'form-control'],
                'constraints' => new NotBlank()
            ])
            ->add('pseudo', TextType::class, [
                'label' => 'Votre pseudo',
                'attr' => ['class' => 'form-control'],
                'constraints' => new NotBlank()
            ])
            ->add('contenu', CKEditorType::class, [
                'label' => 'Votre commentaire',
                'attr' => ['class' => 'form-control'],
                'constraints' => new NotBlank()
            ])
            ->add('rgpd', CheckboxType::class, [
                'label' => "J'accepte les conditions RGPD",
                'attr' => ['class' => 'form-control commentaires_rgpd'],
                'constraints' => new NotBlank()
            ])

            ->add('parentid', HiddenType::class, [
                'mapped' => false
            ])   
            ->add('note',HiddenType::class,['attr'=>['id'=>'note']])
            ->add('Envoyer', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary btn-centered']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaires::class,
        ]);
    }
}
