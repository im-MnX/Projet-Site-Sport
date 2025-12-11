<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ORM\Table(name: "produit")]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idProduit", type: "integer")]
    private ?int $idProduit = null;

    #[ORM\Column(name: "nomProduit", type: "string", length: 255)]
    private ?string $nomProduit = null;

    #[ORM\Column(name: "description", type: "text", nullable: true)]
    private ?string $description = null;

    #[ORM\Column(name: "prix", type: "decimal", precision: 10, scale: 2)]
    private ?string $prix = null; // string pour decimal

    #[ORM\Column(name: "stock", type: "integer")]
    private ?int $stock = null;

    public function getIdProduit(): ?int { return $this->idProduit; }
    public function getNomProduit(): ?string { return $this->nomProduit; }
    public function setNomProduit(string $nomProduit): static { $this->nomProduit = $nomProduit; return $this; }
    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): static { $this->description = $description; return $this; }
    public function getPrix(): ?string { return $this->prix; }
    public function setPrix(string $prix): static { $this->prix = $prix; return $this; }
    public function getStock(): ?int { return $this->stock; }
    public function setStock(int $stock): static { $this->stock = $stock; return $this; }
}
