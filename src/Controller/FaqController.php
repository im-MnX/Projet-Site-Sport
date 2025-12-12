<?php

namespace App\Controller;

use App\Entity\Faq;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class FaqController extends AbstractController
{
    #[Route('/faq', name: 'app_faq')]
    public function index(ManagerRegistry $doctrine): Response
    {
        // Récupérer le repository de l'entité Faq
        $repository = $doctrine->getRepository(Faq::class);

        // Récupérer toutes les FAQ
        $faq = $repository->findAll();

        return $this->render('faq/index.html.twig', [
            'faq' => $faq,
        ]);
    }
}
