<?php

namespace App\Repository;

use App\Entity\Document;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Document::class);
    }

    /**
     * @return Document[] Returns an array of Document objects
     */
    public function findByCategoryName(string $categoryName): array
    {
        return $this->createQueryBuilder('d')
            ->join('d.categorie', 'c')
            ->andWhere('c.nom = :val')
            ->setParameter('val', $categoryName)
            ->orderBy('d.titre', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
