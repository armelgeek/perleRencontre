<?php

namespace App\Form;

use App\Entity\Utilisateur;
use App\Form\Type\DateTimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Form\DataTransformer\DateTimeTransformer;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => "Nom d'utilisateur",
                'required' => true,
            ])
            ->add('email', TextType::class, [
                'label' => "Adresse email",
                'required' => true
            ])
            ->add('password', RepeatedType::class, array(
                'required' => true,
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Confirmer le mot de passe'),
            ))
            ->add('genre', ChoiceType::class, [
                'choices' => [
                    'Femme' => 0,
                    'Garcon' => 1,
                ],
                'expanded' => true,
                'multiple' => false,
                'label' => 'Genre:',
                'required' => true
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
                'label' => 'Je Cherche :',
                'required' => true
            ])
            ->add('date_naissance', DateTimeType::class, array(
                'required' => true,
                'label' => false,
                'attr' => ['class' => 'js-datepicker'],
                'format' => 'yyyy-MM-dd'

            ))
            ->add('ville', TextType::class, [
                'label' => "Ville",
                'required' => false,
            ])
            ->add('adresse', TextareaType::class, [
                'label' => "Adresse",
                'required' => false,
            ])
            ->add('certifie', CheckboxType::class, [
                'label'    => false,
                'required' => true

            ])
            ->add('condition_generale', CheckboxType::class, [
                'label'    => "En cochant cette case , je certifie être majeur et responsable",
                'required' => true
            ])
            ->add('condition_vente', CheckboxType::class, [
                'label'    => "J'ai lu et accepte les conditions génerales d'utilisations",
                'required' => true
            ])
            ->add('peut_envoyer_mail_depuis_le_site', CheckboxType::class, [
                'label'    => "J'ai lu et accepte les conditions génerales de vente",
                'required' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}