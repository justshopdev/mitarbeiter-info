<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class NewsRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        public readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct($registry, News::class);
    }
}
