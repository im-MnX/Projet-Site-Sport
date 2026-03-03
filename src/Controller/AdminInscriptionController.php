<?php

namespace App\Controller;

use App\Entity\Inscription;
use App\Form\InscriptionType;
use App\Repository\InscriptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/inscription')]
#[IsGranted('ROLE_ADMIN')]
final class AdminInscriptionController extends AbstractController
{
    #[Route(name: 'app_admin_inscription_index', methods: ['GET'])]
    public function index(InscriptionRepository $inscriptionRepository): Response
    {
        return $this->render('admin_inscription/index.html.twig', [
            'inscriptions' => $inscriptionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_inscription_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $inscription = new Inscription();
        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($inscription);
            $entityManager->flush();

            $this->addFlash('success', 'La page inscription a été créée avec succès.');

            return $this->redirectToRoute('app_admin_inscription_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_inscription/new.html.twig', [
            'inscription' => $inscription,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_inscription_show', methods: ['GET'])]
    public function show(Inscription $inscription): Response
    {
        return $this->render('admin_inscription/show.html.twig', [
            'inscription' => $inscription,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_inscription_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Inscription $inscription, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(InscriptionType::class, $inscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'La page inscription a été mise à jour avec succès.');

            return $this->redirectToRoute('app_admin_inscription_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_inscription/edit.html.twig', [
            'inscription' => $inscription,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_inscription_delete', methods: ['POST'])]
    public function delete(Request $request, Inscription $inscription, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $inscription->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($inscription);
            $entityManager->flush();

            $this->addFlash('success', 'L\'entrée a été supprimée.');
        }

        return $this->redirectToRoute('app_admin_inscription_index', [], Response::HTTP_SEE_OTHER);
    }
}
