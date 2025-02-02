<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<News>
 */
class NewsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
    }

    public function findNewsForTitleAndDate(string $title, \DateTimeImmutable $date): null|News
    {
        $qb = $this->createQueryBuilder('n')
            ->where('n.title = :title')
            ->andWhere('n.parsedAt = :date')
            ->setParameter('title', $title)
            ->setParameter('date', $date)
            ->getQuery();

        return $qb->getOneOrNullResult();
    }
}
