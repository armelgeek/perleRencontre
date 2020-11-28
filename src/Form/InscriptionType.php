<?php

namespace App\Form;

use App\Entity\Utilisateur;
use App\Form\Type\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Form\DataTransformer\DateTimeTransformer;
class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => "Nom d'utilisateur",
                 'required' =>true,
            ])
            ->add('password', RepeatedType::class, array(
                    'required' => true,
                    'type' => PasswordType::class,
                    'first_options'  => array('label' => 'Mot de passe'),
                    'second_options' => array('label' => 'Confirmer le mot de passe'),
            ))
             ->add('genre', ChoiceType::class, [
                'choices' => [
                    'Femme' => 'GENRE_FEMME',
                    'Garcon' => 'GENRE_GARCON',
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Genre'
            ])
            ->add('jeCherche', ChoiceType::class, [
                'choices' => [
                    'Femme' => 'JECHERCHE_FEMME',
                    'Garcon' => 'JECHERCHE_GARCON',
                    'Gay' => 'JECHERCHE_GAY',
                    'Lesbienne' => 'JECHERCHE_LESBIENNE',
                    'Homme bi' => 'JECHERCHE_HOMME_BI',
                    'Femme bi' => 'JECHERCHE_FEMME_BI',
                ],
                'expanded' => true,
                'multiple' => true,
                'label' => 'Je Cherche'
            ])
             ->add('date_naissance',DateTimeType::class, array(
                'required' => true,
                'label' => 'Date de naissance',
                'attr' => ['class' => 'js-datepicker'],
                'format' => 'yyyy-MM-dd'

            ))
             ->add('adresse', TextType::class, [
                'label' => "Adresse"
            ]);      
         /*   ->add('certifie', CheckboxType::class, [
                'label'    => 'En cochant cette case , je certifie être majeur et responsable',
               'required' => true,
            ])
           
            ->add('conditionGenerale', CheckboxType::class, [
                'label'    => "J'ai lu et accepte les conditions génerales d'utilisations",
               'required' => true,
            ])
            ->add('conditionVente', CheckboxType::class, [
                'label'    => "J'ai lu et accepte les conditions génerales de vente",
               'required' => true,
            ])*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
