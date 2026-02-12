<?php

namespace App\Entity;

use App\Repository\CategorieAlbumRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: CategorieAlbumRepository::class)]
#[ORM\Table(name: "categoriealbum")]
class CategorieAlbum
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idCategorieAlbum", type: "integer")]
    private ?int $idCategorieAlbum = null;

    #[ORM\Column(name: "libelleCategorieAlbum", type: "string", length: 100)]
    private ?string $libelleCategorieAlbum = null;

    #[ORM\OneToMany(mappedBy: "idCategorieAlbum", targetEntity: Album::class,cascade: ["remove"], orphanRemoval: true)]
    private Collection $albums;

    public function __construct() { $this->albums = new ArrayCollection(); }

    public function getId(): ?int
    {
    return $this->idCategorieAlbum;
    }

    public function getIdCategorieAlbum(): ?int { return $this->idCategorieAlbum; }
    public function getLibelleCategorieAlbum(): ?string { return $this->libelleCategorieAlbum; }
    public function setLibelleCategorieAlbum(string $libelle): static { $this->libelleCategorieAlbum = $libelle; return $this; }
    public function getAlbums(): Collection { return $this->albums; }
}
