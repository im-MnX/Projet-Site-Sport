<?php

namespace App\Entity;

use App\Repository\AlbumRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: AlbumRepository::class)]
#[ORM\Table(name: "album")]
class Album
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idAlbum", type: "integer")]
    private ?int $idAlbum = null;

    #[ORM\Column(name: "description", type: "text", nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: CategorieAlbum::class, inversedBy: "albums")]
    #[ORM\JoinColumn(name: "idCategorieAlbum", referencedColumnName: "idCategorieAlbum", nullable: false)]
    private ?CategorieAlbum $idCategorieAlbum = null;

    #[ORM\Column(name: "priorite", type: "integer", options: ["default" => 0])]
    private int $priorite = 0;

    #[ORM\Column(name: "archive", type: "boolean", options: ["default" => false])]
    private bool $archive = false;

    #[ORM\OneToMany(mappedBy: "idAlbum", targetEntity: Photo::class,cascade: ["remove"],orphanRemoval: true)]
    private Collection $photos;

    public function __construct() { $this->photos = new ArrayCollection(); }

    public function getId(): ?int
    {
    return $this->idAlbum;
    }
    public function getIdAlbum(): ?int { return $this->idAlbum; }
    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): static { $this->description = $description; return $this; }
    public function getIdCategorieAlbum(): ?CategorieAlbum { return $this->idCategorieAlbum; }
    public function setIdCategorieAlbum(?CategorieAlbum $idCategorieAlbum): static { $this->idCategorieAlbum = $idCategorieAlbum; return $this; }
    public function getPriorite(): int { return $this->priorite; }
    public function setPriorite(int $priorite): static { $this->priorite = $priorite; return $this; }
    public function isArchive(): bool { return $this->archive; }
    public function setArchive(bool $archive): static { $this->archive = $archive; return $this; }
    public function getPhotos(): Collection { return $this->photos; }
}
