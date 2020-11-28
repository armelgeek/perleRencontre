<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use App\Entity\Video;


class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('videopath', FileType::class, [
                'label' => 'Votre vidéo',
                'mapped' => false,
                'required' => true,
                'attr' => ['capture' => ''],
                'constraints' => [
                    new File([
                        'maxSize' => '512M',
                        'mimeTypes' => [
                            'video/*'
                        ],
                        'mimeTypesMessage' => 'Veuiller choisir un fichier vidéo'
                    ])
                ]
            ])
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('description', TextType::class, ['label' => 'Déscription'])
            ->add('privat', CheckboxType::class, [
                'required' => false,
                'label' => 'Vidéo privé',
            ])
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
