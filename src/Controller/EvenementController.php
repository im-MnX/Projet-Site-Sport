<?php

namespace App\Controller;

use App\Entity\Evenement;  // <-- IMPORTANT !
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EvenementController extends AbstractController
{

    #[Route('/evenements', name: 'app_evenement')]
    public function index(EvenementRepository $repo): Response
    {
        // Récupérer tous les événements triés par dateEvenement décroissante
        $evenements = $repo->findBy([], ['dateEvenement' => 'DESC']);

        return $this->render('evenements/index.html.twig', [
            'evenements' => $evenements,
        ]);
    }
}
