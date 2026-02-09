<?php

namespace App\Controller;

use App\Entity\CategorieAlbum;
use App\Form\CategorieAlbumType;
use App\Repository\CategorieAlbumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/categorie/album')]
final class AdminCategorieAlbumController extends AbstractController
{
    #[Route(name: 'app_admin_categorie_album_index', methods: ['GET'])]
    public function index(CategorieAlbumRepository $categorieAlbumRepository): Response
    {
        return $this->render('admin_categorie_album/index.html.twig', [
            'categorie_albums' => $categorieAlbumRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_categorie_album_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorieAlbum = new CategorieAlbum();
        $form = $this->createForm(CategorieAlbumType::class, $categorieAlbum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorieAlbum);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_categorie_album_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_categorie_album/new.html.twig', [
            'categorie_album' => $categorieAlbum,
            'form' => $form,
        ]);
    }

    #[Route('/{idCategorieAlbum}', name: 'app_admin_categorie_album_show', methods: ['GET'])]
    public function show(CategorieAlbum $categorieAlbum): Response
    {
        return $this->render('admin_categorie_album/show.html.twig', [
            'categorie_album' => $categorieAlbum,
        ]);
    }

    #[Route('/{idCategorieAlbum}/edit', name: 'app_admin_categorie_album_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategorieAlbum $categorieAlbum, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategorieAlbumType::class, $categorieAlbum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_categorie_album_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_categorie_album/edit.html.twig', [
            'categorie_album' => $categorieAlbum,
            'form' => $form,
        ]);
    }

    #[Route('/{idCategorieAlbum}', name: 'app_admin_categorie_album_delete', methods: ['POST'])]
    public function delete(Request $request, CategorieAlbum $categorieAlbum, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieAlbum->getIdCategorieAlbum(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($categorieAlbum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_categorie_album_index', [], Response::HTTP_SEE_OTHER);
    }
}
