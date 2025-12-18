<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ResultatsController extends AbstractController
{
    #[Route('/resultats', name: 'app_resultats')]
    public function index(): Response
    {
        return $this->render('resultats/resultats.html.twig', [
            'controller_name' => 'ResultatsController',
        ]);
    }
}
