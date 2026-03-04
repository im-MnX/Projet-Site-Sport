<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvenementRepository::class)]
#[ORM\Table(name: "evenement")]
class Evenement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idEvenement", type: "integer")]
    private ?int $idEvenement = null;

    #[ORM\Column(name: "nom", length: 100)]
    private ?string $nom = null;

    #[ORM\Column(name: "dateDebut", type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateDebut = null;

    #[ORM\Column(name: "dateFin", type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateFin = null;

    #[ORM\Column(name: "images", length: 255, nullable: true)]
    private ?string $images = null;

    #[ORM\Column(name: "description", type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: TypeEvenement::class, inversedBy: "evenements")]
    #[ORM\JoinColumn(name: "idTypeEvenement", referencedColumnName: "idTypeEvenement", nullable: false)]
    private ?TypeEvenement $typeEvenement = null;

    #[ORM\Column(name: "horaire", type: Types::TIME_MUTABLE)]
    private ?\DateTime $horaire = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $brochureFilename = null;


    public function getIdEvenement(): ?int
    {
        return $this->idEvenement;
    }

    public function getId(): ?int
    {
        return $this->idEvenement;
    }


    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getDateDebut(): ?\DateTime
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTime $dateDebut): static
    {
        $this->dateDebut = $dateDebut;
        return $this;
    }

    public function getDateFin(): ?\DateTime
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTime $dateFin): static
    {
        $this->dateFin = $dateFin;
        return $this;
    }

    public function getImages(): ?string
    {
        return $this->images;
    }

    public function setImages(?string $images): static
    {
        $this->images = $images;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getTypeEvenement(): ?TypeEvenement
    {
        return $this->typeEvenement;
    }

    public function setTypeEvenement(?TypeEvenement $typeEvenement): static
    {
        $this->typeEvenement = $typeEvenement;
        return $this;
    }

    public function getHoraire(): ?\DateTime
    {
        return $this->horaire;
    }

    public function setHoraire(?\DateTime $horaire): static
    {
        $this->horaire = $horaire;
        return $this;
    }

    public function getBrochureFilename(): ?string
    {
        return $this->brochureFilename;
    }

    public function setBrochureFilename(?string $brochureFilename): static
    {
        $this->brochureFilename = $brochureFilename;

        return $this;
    }
}
