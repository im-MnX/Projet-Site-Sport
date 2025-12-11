<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ORM\Table(name: "commande")]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idCommande", type: "integer")]
    private ?int $idCommande = null;

    #[ORM\Column(name: "dateCommande", type: "date")]
    private ?\DateTime $dateCommande = null;

    public function getIdCommande(): ?int { return $this->idCommande; }
    public function getDateCommande(): ?\DateTime { return $this->dateCommande; }
    public function setDateCommande(\DateTime $dateCommande): static { $this->dateCommande = $dateCommande; return $this; }
}
