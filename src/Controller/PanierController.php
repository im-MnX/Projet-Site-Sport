<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(SessionInterface $session, ManagerRegistry $doctrine): Response
    {
        $panier = $session->get('panier', []);
        $produitRepo = $doctrine->getRepository(Produit::class);

        $produitsPanier = [];
        $total = 0;

        foreach ($panier as $idProduit => $quantite) {
            $produit = $produitRepo->find($idProduit);
            if ($produit) {
                $prix = (float) $produit->getPrix();
                $produitsPanier[] = [
                    'produit' => $produit,
                    'quantite' => $quantite,
                    'sous_total' => $prix * $quantite,
                ];
                $total += $prix * $quantite;
            }
        }

        return $this->render('panier/index.html.twig', [
            'produitsPanier' => $produitsPanier,
            'total' => $total,
        ]);
    }

    #[Route('/panier/ajouter/{id}', name: 'app_panier_ajouter')]
    public function ajouter(Produit $produit, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);
        $idProduit = $produit->getIdProduit();
        $panier[$idProduit] = ($panier[$idProduit] ?? 0) + 1;
        $session->set('panier', $panier);

        $this->addFlash('success', $produit->getNomProduit() . ' a été ajouté au panier.');

        return $this->redirectToRoute('app_boutique');
    }

    #[Route('/panier/supprimer/{id}', name: 'app_panier_supprimer')]
    public function supprimer(Produit $produit, SessionInterface $session): Response
    {
        $panier = $session->get('panier', []);
        $idProduit = $produit->getIdProduit();

        if (isset($panier[$idProduit])) {
            unset($panier[$idProduit]);
            $session->set('panier', $panier);
            $this->addFlash('success', $produit->getNomProduit() . ' a été retiré du panier.');
        }

        return $this->redirectToRoute('app_panier');
    }
}
