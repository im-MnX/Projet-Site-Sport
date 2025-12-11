<?php

namespace App\Repository;

use App\Entity\Faq;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class FaqRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Faq::class);
    }

    // Exemple : chercher une FAQ par question exacte
    public function findByQuestion(string $question): ?Faq
    {
        return $this->createQueryBuilder('f')
            ->where('f.question = :question')
            ->setParameter('question', $question)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
