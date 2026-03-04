<?php

namespace App\Controller;

use App\Repository\InscriptionRepository;
use App\Repository\DocumentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(
        InscriptionRepository $inscriptionRepository,
        DocumentRepository $documentRepository
    ): Response {
        $inscription = $inscriptionRepository->findOneBy([]);
        $documents = $documentRepository->findByCategoryName('Inscription');

        return $this->render('inscription/index.html.twig', [
            'inscription' => $inscription,
            'documents' => $documents,
        ]);
    }
}
