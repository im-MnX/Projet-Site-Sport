<?php

namespace App\Controller;

use App\Entity\Actualite;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

final class ActualitesController extends AbstractController
{
    #[Route('/actualites', name: 'app_actualites')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Actualite::class);

        // Trier par date décroissante (du plus récent au plus ancien)
        $actualites = $repository->findBy(
            [],                 // pas de condition
            ['date' => 'DESC']  // champ => ordre
        );

        return $this->render('actualites/index.html.twig', [
            'actualites' => $actualites,
        ]);
    }

    #[Route('/actualites/{id}', name: 'app_actualites_show')]
    public function show(
        #[MapEntity(id: 'id')] Actualite $actualite
    ): Response {
        return $this->render('actualites/show.html.twig', [
            'actualite' => $actualite,
        ]);
    }
}
