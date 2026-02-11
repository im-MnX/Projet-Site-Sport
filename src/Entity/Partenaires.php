<?php

namespace App\Entity;

use App\Repository\PartenairesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartenairesRepository::class)]
class Partenaires
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomPartenaire = null;

    #[ORM\Column(length: 255)]
    private ?string $logoPartenaire = null;

    #[ORM\Column(length: 500)]
    private ?string $lienPartenaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPartenaire(): ?string
    {
        return $this->nomPartenaire;
    }

    public function setNomPartenaire(string $nomPartenaire): static
    {
        $this->nomPartenaire = $nomPartenaire;

        return $this;
    }

    public function getLogoPartenaire(): ?string
    {
        return $this->logoPartenaire;
    }

    public function setLogoPartenaire(string $logoPartenaire): static
    {
        $this->logoPartenaire = $logoPartenaire;

        return $this;
    }

    public function getLienPartenaire(): ?string
    {
        return $this->lienPartenaire;
    }

    public function setLienPartenaire(string $lienPartenaire): static
    {
        $this->lienPartenaire = $lienPartenaire;

        return $this;
    }
}
