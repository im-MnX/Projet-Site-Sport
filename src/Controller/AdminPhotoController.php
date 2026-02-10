<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Form\PhotoType;
use App\Repository\PhotoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Filesystem\Filesystem;

#[Route('/admin/photo')]
final class AdminPhotoController extends AbstractController
{
    #[Route(name: 'app_admin_photo_index', methods: ['GET'])]
    public function index(PhotoRepository $idPhotoRepository): Response
    {
        return $this->render('admin_photo/index.html.twig', [
            'photos' => $idPhotoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_photo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $idPhoto = new Photo();
        $form = $this->createForm(PhotoType::class, $idPhoto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                $albumId = $idPhoto->getIdAlbum()->getIdAlbum();
                $targetDirectory = $this->getParameter('kernel.project_dir').'/public/photos/album_'.$albumId;

                $filesystem = new Filesystem();
                if (!$filesystem->exists($targetDirectory)) {
                    $filesystem->mkdir($targetDirectory, 0777, true);
                }

                try {
                    $imageFile->move($targetDirectory, $newFilename);
                    $idPhoto->setCheminImage($newFilename);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
            }

            $entityManager->persist($idPhoto);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_photo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_photo/new.html.twig', [
            'photo' => $idPhoto,
            'form' => $form,
        ]);
    }

    #[Route('/{idPhoto}', name: 'app_admin_photo_show', methods: ['GET'])]
    public function show(Photo $idPhoto): Response
    {
        return $this->render('admin_photo/show.html.twig', [
            'photo' => $idPhoto,
        ]);
    }

    #[Route('/{idPhoto}/edit', name: 'app_admin_photo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Photo $idPhoto, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        // On mémorise l'ID de l'album actuel avant que le formulaire ne change l'entité
        $oldAlbumId = $idPhoto->getIdAlbum()->getIdAlbum();
        $oldFilename = $idPhoto->getCheminImage();

        $form = $this->createForm(PhotoType::class, $idPhoto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            $filesystem = new Filesystem();
            $projectDir = $this->getParameter('kernel.project_dir');

            if ($imageFile) {
                // Si une nouvelle image est uploadée
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                $newAlbumId = $idPhoto->getIdAlbum()->getIdAlbum();
                $targetDirectory = $projectDir.'/public/photos/album_'.$newAlbumId;

                if (!$filesystem->exists($targetDirectory)) {
                    $filesystem->mkdir($targetDirectory, 0777, true);
                }

                try {
                    $imageFile->move($targetDirectory, $newFilename);
                    $idPhoto->setCheminImage($newFilename);

                    // Supprimer l'ancienne image si elle existe
                    if ($oldFilename) {
                        $oldFilePath = $projectDir.'/public/photos/album_'.$oldAlbumId.'/'.$oldFilename;
                        if ($filesystem->exists($oldFilePath)) {
                            $filesystem->remove($oldFilePath);
                        }
                    }
                } catch (FileException $e) {
                    // ... handle exception
                }
            } else {
                // Si on a SEULEMENT changé d'album (sans uploader de nouvelle image)
                $newAlbumId = $idPhoto->getIdAlbum()->getIdAlbum();
                
                if ($newAlbumId !== $oldAlbumId && $oldFilename) {
                    $oldFilePath = $projectDir.'/public/photos/album_'.$oldAlbumId.'/'.$oldFilename;
                    $targetDirectory = $projectDir.'/public/photos/album_'.$newAlbumId;
                    $newFilePath = $targetDirectory.'/'.$oldFilename;

                    if (!$filesystem->exists($targetDirectory)) {
                        $filesystem->mkdir($targetDirectory, 0777, true);
                    }

                    if ($filesystem->exists($oldFilePath)) {
                        $filesystem->rename($oldFilePath, $newFilePath);
                    }
                }
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_admin_photo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_photo/edit.html.twig', [
            'photo' => $idPhoto,
            'form' => $form,
        ]);
    }

    #[Route('/{idPhoto}', name: 'app_admin_photo_delete', methods: ['POST'])]
    public function delete(Request $request, Photo $idPhoto, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$idPhoto->getIdPhoto(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($idPhoto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_photo_index', [], Response::HTTP_SEE_OTHER);
    }
}
