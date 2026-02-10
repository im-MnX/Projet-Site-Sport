<?php

namespace App\Controller;

use App\Entity\TypeEvenement;
use App\Form\TypeEvenementType;
use App\Repository\TypeEvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/type/evenement')]
final class AdminTypeEvenementController extends AbstractController
{
    #[Route(name: 'app_admin_type_evenement_index', methods: ['GET'])]
    public function index(TypeEvenementRepository $typeEvenementRepository): Response
    {
        return $this->render('admin_type_evenement/index.html.twig', [
            'type_evenements' => $typeEvenementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_type_evenement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeEvenement = new TypeEvenement();
        $form = $this->createForm(TypeEvenementType::class, $typeEvenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeEvenement);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_type_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_type_evenement/new.html.twig', [
            'type_evenement' => $typeEvenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_type_evenement_show', methods: ['GET'])]
    public function show(TypeEvenement $typeEvenement): Response
    {
        return $this->render('admin_type_evenement/show.html.twig', [
            'type_evenement' => $typeEvenement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_type_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeEvenement $typeEvenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeEvenementType::class, $typeEvenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_type_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_type_evenement/edit.html.twig', [
            'type_evenement' => $typeEvenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_type_evenement_delete', methods: ['POST'])]
    public function delete(Request $request, TypeEvenement $typeEvenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeEvenement->getIdTypeEvenement(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($typeEvenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_type_evenement_index', [], Response::HTTP_SEE_OTHER);
    }
}
