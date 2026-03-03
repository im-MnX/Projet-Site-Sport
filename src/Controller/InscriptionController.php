<?php

namespace App\Controller;

use App\Repository\InscriptionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(InscriptionRepository $inscriptionRepository): Response
    {
        $inscription = $inscriptionRepository->findOneBy([]);

        return $this->render('inscription/index.html.twig', [
            'inscription' => $inscription,
        ]);
    }
}
