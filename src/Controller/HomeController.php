<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Actualite;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    public function index(ManagerRegistry $doctrine): Response
    {
        // Récupérer les événements à venir (date >= aujourd'hui), limités à 3
        $evenements = $doctrine->getRepository(Evenement::class)->createQueryBuilder('e')
            ->where('e.dateEvenement >= :now')
            ->setParameter('now', new \DateTime())
            ->orderBy('e.dateEvenement', 'ASC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();

        // Récupérer les actualités, limitées à 4
        $actualites = $doctrine->getRepository(Actualite::class)->findBy([], ['date' => 'DESC'], 4);

        return $this->render('home/index.html.twig', [
            'upcomingEvents' => $evenements,
            'latestNews' => $actualites,
        ]);
    }
}
