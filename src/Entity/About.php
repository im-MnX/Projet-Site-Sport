<?php

namespace App\Entity;

use App\Repository\AboutRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AboutRepository::class)]
#[ORM\Table(name: "about")]
class About
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idAbout", type: "integer")]
    private ?int $idAbout = null;

    #[ORM\Column(name: "titre", type: "string", length: 255)]
    private ?string $titre = null;

    #[ORM\Column(name: "contenu", type: "text")]
    private ?string $contenu = null;

    public function getIdAbout(): ?int
    {
        return $this->idAbout;
    }
    public function getTitre(): ?string
    {
        return $this->titre;
    }
    public function setTitre(string $titre): static
    {
        $this->titre = $titre;
        return $this;
    }
    public function getContenu(): ?string
    {
        return $this->contenu;
    }
    public function setContenu(string $contenu): static
    {
        $this->contenu = $contenu;
        return $this;
    }
}
