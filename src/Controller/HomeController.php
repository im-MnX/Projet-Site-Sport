<?php

namespace App\Controller;

use App\Entity\Evenement;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    public function index(ManagerRegistry $doctrine): Response
    {
        // Récupérer le repository de l'entité Evenement
        $repository = $doctrine->getRepository(Evenement::class);

        // Récupérer tous les événements
        $evenements = $repository->findAll();

        return $this->render('home/index.html.twig', [
            'evenements' => $evenements,
        ]);
    }
}
