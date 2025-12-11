<?php

namespace App\Entity;

use App\Repository\FaqRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FaqRepository::class)]
#[ORM\Table(name: "faq")]
class Faq
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "idFaq", type: "integer")]
    private ?int $idFaq = null;

    #[ORM\Column(name: "question", type: "string", length: 255)]
    private ?string $question = null;

    #[ORM\Column(name: "reponse", type: "text")]
    private ?string $reponse = null;

    public function getIdFaq(): ?int { return $this->idFaq; }
    public function getQuestion(): ?string { return $this->question; }
    public function setQuestion(string $question): static { $this->question = $question; return $this; }
    public function getReponse(): ?string { return $this->reponse; }
    public function setReponse(string $reponse): static { $this->reponse = $reponse; return $this; }
}
