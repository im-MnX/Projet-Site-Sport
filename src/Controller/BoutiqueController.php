<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BoutiqueController extends AbstractController
{
    #[Route('/boutique', name: 'app_boutique')]
    public function index(ManagerRegistry $doctrine): Response
    {
        // Récupérer tous les produits
        $produits = $doctrine->getRepository(Produit::class)->findAll();

        return $this->render('boutique/index.html.twig', [
            'produits' => $produits,
        ]);
    }
}
