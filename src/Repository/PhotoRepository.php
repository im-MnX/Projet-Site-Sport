<?php

namespace App\Repository;

use App\Entity\Photo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PhotoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Photo::class);
    }

    // Exemple : récupérer les photos d'un album
    public function findByAlbum(int $idAlbum): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.idAlbum = :idAlbum')
            ->setParameter('idAlbum', $idAlbum)
            ->getQuery()
            ->getResult();
    }
}
