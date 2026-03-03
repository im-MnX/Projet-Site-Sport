<?php

namespace App\Form;

use App\Entity\Inscription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('permanencesTexte', TextareaType::class, [
                'label' => 'Texte des permanences',
                'required' => false,
                'attr' => [
                    'class' => 'description-wysiwyg',
                    'rows' => 6,
                ],
                'help' => 'Décrivez les dates et horaires des permanences (HTML accepté).',
            ])
            ->add('lienHelloasso', TextType::class, [
                'label' => 'Lien HelloAsso',
                'required' => false,
                'attr' => ['placeholder' => 'https://www.helloasso.com/associations/...'],
            ])
            ->add('contactNom', TextType::class, [
                'label' => 'Nom du contact',
                'required' => false,
                'attr' => ['placeholder' => 'Ex: Rachel le Bozec'],
            ])
            ->add('contactEmail', EmailType::class, [
                'label' => 'Email du secrétariat',
                'required' => false,
                'attr' => ['placeholder' => 'secretariat@club.com'],
            ])
            ->add('contactTexte', TextType::class, [
                'label' => 'Phrase d\'introduction contact',
                'required' => false,
                'attr' => ['placeholder' => 'Pour toutes nouvelles inscriptions, contactez le secrétariat par mail'],
            ])
            ->add('contactPhoto', TextType::class, [
                'label' => 'Chemin vers la photo du contact',
                'required' => false,
                'attr' => ['placeholder' => 'images/RachelLeBozec.jpg'],
                'help' => 'Chemin relatif dans le dossier public/, ex: images/MonFichier.jpg',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
