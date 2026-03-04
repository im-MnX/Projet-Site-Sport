<?php

namespace App\Entity;

use App\Repository\ResultatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResultatRepository::class)]
#[ORM\Table(name: "resultat")]
class Resultat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idResultat", type: "integer")]
    private ?int $idResultat = null;

    #[ORM\Column(name: "titre", type: "string", length: 255)]
    private ?string $titre = null;

    #[ORM\Column(name: "contenu", type: "text")]
    private ?string $contenu = null;

    public function getIdResultat(): ?int
    {
        return $this->idResultat;
    }

    public function getId(): ?int
    {
        return $this->idResultat;
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
