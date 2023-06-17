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
                'attr' => ['class' => 'form-control']
            ])
            ->add('pseudo', TextType::class, [
                'label' => 'Votre pseudo',
                'attr' => ['class' => 'form-control']
            ])
            ->add('contenu', CKEditorType::class, [
                'label' => 'Votre commentaire',
                'attr' => ['class' => 'form-control']
            ])
            ->add('rgpd', CheckboxType::class,[
                'label'=>"J'accepte les conditions RGPD",
                'constraints'=>new NotBlank()
            ])
        
            ->add('parentid', HiddenType::class, [
                'mapped' => false
            ])
            ->add('note',ChoiceType::class,[
                'label'=>'Ma note :',               
                'choices'=>[0,1,2,3,4,5,6,7,8,9,10]
            ])
            ->add('Envoyer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaires::class,
        ]);
    }
}
