<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Autres\RechercheRapide;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
class RechercheRapideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
             ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Utilisateur' => 'USER',
                    'Administrateur' => 'ADMIN',
                ],
                'expanded' => false,
                'multiple' => false,
                'label' => 'Rôles'
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RechercheRapide::class,
        ]);
    }
}
