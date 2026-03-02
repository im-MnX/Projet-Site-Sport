<?php

namespace App\Controller;

use App\Entity\QuickAccess;
use App\Form\QuickAccessType;
use App\Repository\QuickAccessRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/quick-access')]
#[IsGranted('ROLE_ADMIN')]
final class AdminQuickAccessController extends AbstractController
{
    #[Route('', name: 'app_admin_quick_access_index', methods: ['GET'])]
    public function index(QuickAccessRepository $repo): Response
    {
        return $this->render('admin_quick_access/index.html.twig', [
            'quick_accesses' => $repo->findBy([], ['position' => 'ASC']),
        ]);
    }

    #[Route('/new', name: 'app_admin_quick_access_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $quickAccess = new QuickAccess();
        $form = $this->createForm(QuickAccessType::class, $quickAccess);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($quickAccess);
            $em->flush();
            $this->addFlash('success', 'Case d\'accès rapide créée avec succès.');
            return $this->redirectToRoute('app_admin_quick_access_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_quick_access/new.html.twig', [
            'quick_access' => $quickAccess,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_quick_access_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, QuickAccess $quickAccess, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(QuickAccessType::class, $quickAccess);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Case d\'accès rapide modifiée avec succès.');
            return $this->redirectToRoute('app_admin_quick_access_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin_quick_access/edit.html.twig', [
            'quick_access' => $quickAccess,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_quick_access_delete', methods: ['POST'])]
    public function delete(Request $request, QuickAccess $quickAccess, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quickAccess->getId(), $request->getPayload()->getString('_token'))) {
            $em->remove($quickAccess);
            $em->flush();
            $this->addFlash('success', 'Case supprimée.');
        }

        return $this->redirectToRoute('app_admin_quick_access_index', [], Response::HTTP_SEE_OTHER);
    }
}
