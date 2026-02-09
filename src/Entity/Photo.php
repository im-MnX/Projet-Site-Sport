<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotoRepository::class)]
#[ORM\Table(name: "photo")]
class Photo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idPhoto", type: "integer")]
    private ?int $idPhoto = null;

    #[ORM\ManyToOne(targetEntity: Album::class, inversedBy: "photos")]
    #[ORM\JoinColumn(name: "idAlbum", referencedColumnName: "idAlbum", nullable: false)]
    private ?Album $idAlbum = null;

    #[ORM\Column(name: "titre", type: "string", length: 255, nullable: true)]
    private ?string $titre = null;

    #[ORM\Column(name: "cheminImage", type: "string", length: 255, nullable: true)]
    private ?string $cheminImage = null;

    #[ORM\Column(name: "datePhoto", type: "date", nullable: true)]
    private ?\DateTime $datePhoto = null;

    public function getId(): ?int
{
    return $this->idPhoto;
}

    public function getIdPhoto(): ?int { return $this->idPhoto; }
    public function getIdAlbum(): ?Album { return $this->idAlbum; }
    public function setIdAlbum(?Album $idAlbum): static { $this->idAlbum = $idAlbum; return $this; }
    public function getTitre(): ?string { return $this->titre; }
    public function setTitre(?string $titre): static { $this->titre = $titre; return $this; }
    public function getCheminImage(): ?string { return $this->cheminImage; }
    public function setCheminImage(?string $cheminImage): static { $this->cheminImage = $cheminImage; return $this; }
    public function getDatePhoto(): ?\DateTime { return $this->datePhoto; }
    public function setDatePhoto(?\DateTime $datePhoto): static { $this->datePhoto = $datePhoto; return $this; }
}
