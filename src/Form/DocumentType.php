<?php

namespace App\Form;

use App\Entity\CategorieDocument;
use App\Entity\Document;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre du document',
                'attr' => ['placeholder' => 'Ex: Planning des cours']
            ])
            ->add('identifiant', TextType::class, [
                'label' => 'Identifiant unique (technique)',
                'help' => 'Utilisé par le code pour identifier ce document précisément.',
                'required' => false,
                'attr' => ['placeholder' => 'Ex: FICHE_INSCRIPTION']
            ])
            ->add('categorie', EntityType::class, [
                'class' => CategorieDocument::class,
                'choice_label' => 'nom',
                'label' => 'Catégorie',
                'placeholder' => 'Choisir une catégorie',
                'required' => false,
            ])
            ->add('documentFile', FileType::class, [
                'label' => 'Fichier (PDF, DOCX, ...)',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '10M',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        ],
                        'mimeTypesMessage' => 'Veuillez uploader un document valide (PDF, DOC, DOCX)',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Document::class,
        ]);
    }
}
