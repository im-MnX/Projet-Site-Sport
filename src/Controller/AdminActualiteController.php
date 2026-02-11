<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Form\ActualiteType;
use App\Repository\ActualiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/actualite')]
final class AdminActualiteController extends AbstractController
{
    #[Route(name: 'app_admin_actualite_index', methods: ['GET'])]
    public function index(ActualiteRepository $actualiteRepository): Response
    {
        return $this->render('admin_actualite/index.html.twig', [
            'actualites' => $actualiteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_actualite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $actualite = new Actualite();
        $form = $this->createForm(ActualiteType::class, $actualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload
            $imageFile = $form->get('imageFile')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('kernel.project_dir').'/public/uploads/actualites',
                        $newFilename
                    );
                    $actualite->setImages($newFilename);
                } catch (FileException $e) {
                    // Handle exception if something happens during file upload
                }
            }

            $entityManager->persist($actualite);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_actualite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_actualite/new.html.twig', [
            'actualite' => $actualite,
            'form' => $form,
        ]);
    }

    #[Route('/{idActualite}', name: 'app_admin_actualite_show', methods: ['GET'])]
    public function show(Actualite $idActualite): Response
    {
        return $this->render('admin_actualite/show.html.twig', [
            'actualite' => $idActualite,
        ]);
    }

    #[Route('/{idActualite}/edit', name: 'app_admin_actualite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Actualite $idActualite, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActualiteType::class, $idActualite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle file upload
            $imageFile = $form->get('imageFile')->getData();
            if ($imageFile) {
                // Delete old image if exists
                $oldImage = $idActualite->getImages();
                if ($oldImage) {
                    $oldImagePath = $this->getParameter('kernel.project_dir').'/public/uploads/actualites/'.$oldImage;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('kernel.project_dir').'/public/uploads/actualites',
                        $newFilename
                    );
                    $idActualite->setImages($newFilename);
                } catch (FileException $e) {
                    // Handle exception if something happens during file upload
                }
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_admin_actualite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_actualite/edit.html.twig', [
            'actualite' => $idActualite,
            'form' => $form,
        ]);
    }

    #[Route('/{idActualite}', name: 'app_admin_actualite_delete', methods: ['POST'])]
    public function delete(Request $request, Actualite $idActualite, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$idActualite->getIdActualite(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($idActualite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_actualite_index', [], Response::HTTP_SEE_OTHER);
    }
}
