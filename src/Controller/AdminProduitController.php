<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/produit')]
#[IsGranted('ROLE_ADMIN')]
final class AdminProduitController extends AbstractController
{
    #[Route(name: 'app_admin_produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('admin_produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{idProduit}', name: 'app_admin_produit_show', methods: ['GET'])]
    public function show(int $idProduit, ProduitRepository $produitRepository): Response
    {
        return $this->render('admin_produit/show.html.twig', [
            'produit' => $produitRepository->find($idProduit),
        ]);
    }

    #[Route('/{idProduit}/edit', name: 'app_admin_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, int $idProduit, ProduitRepository $produitRepository, EntityManagerInterface $entityManager): Response
    {
        $produit = $produitRepository->find($idProduit);
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{idProduit}', name: 'app_admin_produit_delete', methods: ['POST'])]
    public function delete(Request $request, int $idProduit, ProduitRepository $produitRepository, EntityManagerInterface $entityManager): Response
    {
        $produit = $produitRepository->find($idProduit);
        if ($this->isCsrfTokenValid('delete'.$produit->getIdProduit(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_produit_index', [], Response::HTTP_SEE_OTHER);
    }
}
