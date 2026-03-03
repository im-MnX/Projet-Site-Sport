<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InscriptionRepository::class)]
#[ORM\Table(name: "inscription_page")]
class Inscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "id", type: "integer")]
    private ?int $id = null;

    #[ORM\Column(name: "permanences_texte", type: "text", nullable: true)]
    private ?string $permanencesTexte = null;

    #[ORM\Column(name: "lien_helloasso", type: "string", length: 500, nullable: true)]
    private ?string $lienHelloasso = null;

    #[ORM\Column(name: "contact_nom", type: "string", length: 255, nullable: true)]
    private ?string $contactNom = null;

    #[ORM\Column(name: "contact_email", type: "string", length: 255, nullable: true)]
    private ?string $contactEmail = null;

    #[ORM\Column(name: "contact_texte", type: "string", length: 500, nullable: true)]
    private ?string $contactTexte = null;

    #[ORM\Column(name: "contact_photo", type: "string", length: 255, nullable: true)]
    private ?string $contactPhoto = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPermanencesTexte(): ?string
    {
        return $this->permanencesTexte;
    }

    public function setPermanencesTexte(?string $permanencesTexte): static
    {
        $this->permanencesTexte = $permanencesTexte;
        return $this;
    }

    public function getLienHelloasso(): ?string
    {
        return $this->lienHelloasso;
    }

    public function setLienHelloasso(?string $lienHelloasso): static
    {
        $this->lienHelloasso = $lienHelloasso;
        return $this;
    }

    public function getContactNom(): ?string
    {
        return $this->contactNom;
    }

    public function setContactNom(?string $contactNom): static
    {
        $this->contactNom = $contactNom;
        return $this;
    }

    public function getContactEmail(): ?string
    {
        return $this->contactEmail;
    }

    public function setContactEmail(?string $contactEmail): static
    {
        $this->contactEmail = $contactEmail;
        return $this;
    }

    public function getContactTexte(): ?string
    {
        return $this->contactTexte;
    }

    public function setContactTexte(?string $contactTexte): static
    {
        $this->contactTexte = $contactTexte;
        return $this;
    }

    public function getContactPhoto(): ?string
    {
        return $this->contactPhoto;
    }

    public function setContactPhoto(?string $contactPhoto): static
    {
        $this->contactPhoto = $contactPhoto;
        return $this;
    }
}
