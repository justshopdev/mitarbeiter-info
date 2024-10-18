<?php

namespace App\Repository;

use App\Entity\NewsAttachment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class NewsAttachmentRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        public readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct($registry, NewsAttachment::class);
    }
}
