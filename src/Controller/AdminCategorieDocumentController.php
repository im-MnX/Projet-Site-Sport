<?php

namespace App\Controller;

use App\Entity\CategorieDocument;
use App\Form\CategorieDocumentType;
use App\Repository\CategorieDocumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/categorie-document')]
final class AdminCategorieDocumentController extends AbstractController
{
    #[Route(name: 'app_admin_categorie_document_index', methods: ['GET'])]
    public function index(CategorieDocumentRepository $repo): Response
    {
        return $this->render('admin_categorie_document/index.html.twig', [
            'categories' => $repo->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_categorie_document_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorie = new CategorieDocument();
        $form = $this->createForm(CategorieDocumentType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_categorie_document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_categorie_document/new.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_categorie_document_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CategorieDocument $categorie, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategorieDocumentType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_categorie_document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_categorie_document/edit.html.twig', [
            'categorie' => $categorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_categorie_document_delete', methods: ['POST'])]
    public function delete(Request $request, CategorieDocument $categorie, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorie->getId(), $request->request->get('_token'))) {
            // Check if category has documents before deleting or let database handle it if on delete cascade is not set
            // In our case, we might want to prevent deletion if documents exist or just nullify.
            // Since Document.categorie is nullable, it should be fine.
            $entityManager->remove($categorie);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_categorie_document_index', [], Response::HTTP_SEE_OTHER);
    }
}
