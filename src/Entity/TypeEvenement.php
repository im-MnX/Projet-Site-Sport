<?php

namespace App\Entity;

use App\Repository\TypeEvenementRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: TypeEvenementRepository::class)]
#[ORM\Table(name: "typeEvenement")]
class TypeEvenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idTypeEvenement", type: "integer")]
    private ?int $idTypeEvenement = null;

    #[ORM\Column(name: "libelleTypeEvenement", type: "string", length: 50)]
    private ?string $libelleTypeEvenement = null;

    #[ORM\OneToMany(mappedBy: "typeEvenement", targetEntity: Evenement::class)]
    private Collection $evenements;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
    }

    public function getIdTypeEvenement(): ?int
    {
        return $this->idTypeEvenement;
    }

    public function getLibelleTypeEvenement(): ?string
    {
        return $this->libelleTypeEvenement;
    }

    public function setLibelleTypeEvenement(string $libelle): static
    {
        $this->libelleTypeEvenement = $libelle;
        return $this;
    }

    /**
     * @return Collection|Evenement[]
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): static
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements[] = $evenement;
            $evenement->setTypeEvenement($this);
        }
        return $this;
    }

    public function removeEvenement(Evenement $evenement): static
    {
        if ($this->evenements->removeElement($evenement)) {
            if ($evenement->getTypeEvenement() === $this) {
                $evenement->setTypeEvenement(null);
            }
        }
        return $this;
    }
}
