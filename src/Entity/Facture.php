<?php

namespace App\Entity;

use App\Repository\FactureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FactureRepository::class)]
#[ORM\Table(name: "facture")]
class Facture
{
    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Commande::class)]
    #[ORM\JoinColumn(name: "idCommande", referencedColumnName: "idCommande", nullable: false)]
    private ?Commande $idCommande = null;

    #[ORM\Id]
    #[ORM\ManyToOne(targetEntity: Produit::class)]
    #[ORM\JoinColumn(name: "idProduit", referencedColumnName: "idProduit", nullable: false)]
    private ?Produit $idProduit = null;

    #[ORM\Column(name: "quantite", type: "integer")]
    private ?int $quantite = null;

    #[ORM\Column(name: "prixUnitaire", type: "decimal", precision: 10, scale: 2)]
    private ?string $prixUnitaire = null; // string pour decimal

    public function getIdCommande(): ?Commande { return $this->idCommande; }
    public function setIdCommande(?Commande $idCommande): static { $this->idCommande = $idCommande; return $this; }

    public function getIdProduit(): ?Produit { return $this->idProduit; }
    public function setIdProduit(?Produit $idProduit): static { $this->idProduit = $idProduit; return $this; }

    public function getQuantite(): ?int { return $this->quantite; }
    public function setQuantite(int $quantite): static { $this->quantite = $quantite; return $this; }

    public function getPrixUnitaire(): ?string { return $this->prixUnitaire; }
    public function setPrixUnitaire(string $prixUnitaire): static { $this->prixUnitaire = $prixUnitaire; return $this; }
}
