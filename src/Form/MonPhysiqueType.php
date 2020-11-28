<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Form\Type\AgeType;
use App\Form\Type\CouleurDeCheveuxType;
class MonPhysiqueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            
            ->add('age',AgeType::class)
            ->add('couleur_de_cheveux', ChoiceType::class, [
                'choices' => [
                    'NOIR' => 'COULEUR_DES_CHEVEUX_NOIR',
                    'BLEU' => 'COULEUR_DES_CHEVEUX_BLEU',
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'Couleur des yeux'
            ])
            ->add('degaine', ChoiceType::class, [
                'choices' => [
                    'Bad boy' => 'DEGAINE_BAD_BAY',
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'Dégaine'
            ])

        //  ->add('couleur_de_cheveux',CouleurDeCheveuxType::class)
        /*    ->add('degaine')
            ->add('sexualite')
            ->add('taille')
            ->add('style_de_cheveux')
            ->add('silouhette')
            ->add('j_ai_un_faible_pour')
            ->add('poids')
            ->add('couleur_des_yeux')
            ->add('origines')*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
