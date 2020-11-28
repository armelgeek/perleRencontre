<?php

namespace App\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
        
class CouleurDeCheveuxType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
      
          $resolver
                ->setDefaults(array('choices' =>
                [
                    'NOIR' => 'COULEUR_DES_CHEVEUX_NOIR',
                    'BLEU' => 'COULEUR_DES_CHEVEUX_BLEU',
                ],
                'expanded' => true,
                'multiple' => false
            ));
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}