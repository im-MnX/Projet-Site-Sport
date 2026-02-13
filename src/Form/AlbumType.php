<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\CategorieAlbum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length; 

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description', null, [
                'label' => 'Description',
                'constraints' => [
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'La description ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                ],
            ])

            ->add('priorite', null, [
                'label' => 'Priorité',
            ])
            ->add('archive', null, [
                'label' => 'Archivé',
            ])
            ->add('idCategorieAlbum', EntityType::class, [
                'class' => CategorieAlbum::class,
                'choice_label' => 'libelleCategorieAlbum',
                'label' => 'Catégorie Album',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Album::class,
        ]);
    }
}
