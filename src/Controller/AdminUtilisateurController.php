<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/utilisateur')]
final class AdminUtilisateurController extends AbstractController
{
    #[Route(name: 'app_admin_utilisateur_index', methods: ['GET'])]
    public function index(UtilisateurRepository $utilisateurRepository): Response
    {
        return $this->render('admin_utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_utilisateur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $idUtilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $idUtilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($idUtilisateur);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_utilisateur/new.html.twig', [
            'utilisateur' => $idUtilisateur,
            'form' => $form,
        ]);
    }

    #[Route('/{idUtilisateur}', name: 'app_admin_utilisateur_show', methods: ['GET'])]
    public function show(Utilisateur $idUtilisateur): Response
    {
        return $this->render('admin_utilisateur/show.html.twig', [
            'utilisateur' => $idUtilisateur,
        ]);
    }

    #[Route('/{idUtilisateur}/edit', name: 'app_admin_utilisateur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Utilisateur $idUtilisateur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UtilisateurType::class, $idUtilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_utilisateur/edit.html.twig', [
            'utilisateur' => $idUtilisateur,
            'form' => $form,
        ]);
    }

    #[Route('/{idUtilisateur}', name: 'app_admin_utilisateur_delete', methods: ['POST'])]
    public function delete(Request $request, Utilisateur $idUtilisateur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$idUtilisateur->getIdUtilisateur(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($idUtilisateur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_utilisateur_index', [], Response::HTTP_SEE_OTHER);
    }
}
