<?php

namespace App\Repository;

use App\Entity\Partenaires;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PartenairesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Partenaires::class);
    }

    // Exemple : chercher un partenaire par nom
    public function findByNom(string $nom): ?Partenaires
    {
        return $this->createQueryBuilder('p')
            ->where('p.nomPartenaire = :nom')
            ->setParameter('nom', $nom)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
