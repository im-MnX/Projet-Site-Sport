<?php

namespace App\Controller;

use App\Entity\Partenaires;
use App\Form\PartenairesType;
use App\Repository\PartenairesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Filesystem\Filesystem;

#[Route('/admin/partenaires')]
final class AdminPartenairesController extends AbstractController
{
    #[Route(name: 'app_admin_partenaires_index', methods: ['GET'])]
    public function index(PartenairesRepository $partenairesRepository): Response
    {
        return $this->render('admin_partenaires/index.html.twig', [
            'partenaires' => $partenairesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_partenaires_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $partenaire = new Partenaires();
        $form = $this->createForm(PartenairesType::class, $partenaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $logoFile = $form->get('logo')->getData();

            if ($logoFile) {
                $originalFilename = pathinfo($logoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$logoFile->guessExtension();

                $targetDirectory = $this->getParameter('kernel.project_dir').'/public/logos';

                $filesystem = new Filesystem();
                if (!$filesystem->exists($targetDirectory)) {
                    $filesystem->mkdir($targetDirectory, 0777, true);
                }

                try {
                    $logoFile->move($targetDirectory, $newFilename);
                    $partenaire->setLogoPartenaire($newFilename);
                } catch (FileException $e) {
                    // Gérer l'exception si nécessaire
                }
            }

            $entityManager->persist($partenaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_partenaires_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_partenaires/new.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_partenaires_show', methods: ['GET'])]
    public function show(Partenaires $partenaire): Response
    {
        return $this->render('admin_partenaires/show.html.twig', [
            'partenaire' => $partenaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_partenaires_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Partenaires $partenaire, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $oldLogo = $partenaire->getLogoPartenaire();
        
        $form = $this->createForm(PartenairesType::class, $partenaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $logoFile = $form->get('logo')->getData();
            $filesystem = new Filesystem();
            $projectDir = $this->getParameter('kernel.project_dir');

            if ($logoFile) {
                $originalFilename = pathinfo($logoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$logoFile->guessExtension();

                $targetDirectory = $projectDir.'/public/logos';

                if (!$filesystem->exists($targetDirectory)) {
                    $filesystem->mkdir($targetDirectory, 0777, true);
                }

                try {
                    $logoFile->move($targetDirectory, $newFilename);
                    $partenaire->setLogoPartenaire($newFilename);

                    // Supprimer l'ancien logo si il existe
                    if ($oldLogo) {
                        $oldLogoPath = $projectDir.'/public/logos/'.$oldLogo;
                        if ($filesystem->exists($oldLogoPath)) {
                            $filesystem->remove($oldLogoPath);
                        }
                    }
                } catch (FileException $e) {
                    // Gérer l'exception si nécessaire
                }
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_admin_partenaires_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_partenaires/edit.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_partenaires_delete', methods: ['POST'])]
    public function delete(Request $request, Partenaires $partenaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$partenaire->getId(), $request->getPayload()->getString('_token'))) {
            // Supprimer le logo du système de fichiers
            $logo = $partenaire->getLogoPartenaire();
            if ($logo) {
                $filesystem = new Filesystem();
                $logoPath = $this->getParameter('kernel.project_dir').'/public/logos/'.$logo;
                if ($filesystem->exists($logoPath)) {
                    $filesystem->remove($logoPath);
                }
            }

            $entityManager->remove($partenaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_partenaires_index', [], Response::HTTP_SEE_OTHER);
    }
}
