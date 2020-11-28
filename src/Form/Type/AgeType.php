<?php

namespace App\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
        
class AgeType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $age = range(18, 70);
          $resolver
                ->setDefaults(array('choices' => array_combine($age, $age)));
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}