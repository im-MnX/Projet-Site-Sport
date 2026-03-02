<?php

namespace App\Form;

use App\Entity\Document;
use App\Entity\QuickAccess;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuickAccessType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre de la case',
                'attr' => ['placeholder' => 'Ex : Planning des cours'],
            ])
            ->add('icone', TextType::class, [
                'label' => 'Classe Font Awesome',
                'attr' => ['placeholder' => 'Ex : fas fa-calendar-alt'],
                'help' => 'Entrez la classe Font Awesome (ex: fas fa-calendar-alt)',
            ])
            ->add('lien', TextType::class, [
                'label' => 'Lien (URL ou route)',
                'required' => false,
                'attr' => ['placeholder' => 'Ex : /inscription ou https://example.com'],
                'help' => 'URL externe ou chemin interne. Laissez vide si vous choisissez un document.',
            ])
            ->add('document', EntityType::class, [
                'class' => Document::class,
                'choice_label' => 'titre',
                'label' => 'Document lié',
                'required' => false,
                'placeholder' => '-- Aucun document --',
                'help' => 'Sélectionnez un document à la place d\'un lien URL.',
            ])
            ->add('position', IntegerType::class, [
                'label' => 'Position (ordre d\'affichage)',
                'attr' => ['min' => 1, 'max' => 6],
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => QuickAccess::class,
        ]);
    }
}
