<?php

namespace App\Repository;

use App\Entity\LawArticles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LawArticles|null find($id, $lockMode = null, $lockVersion = null)
 * @method LawArticles|null findOneBy(array $criteria, array $orderBy = null)
 * @method LawArticles[]    findAll()
 * @method LawArticles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LawArticlesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LawArticles::class);
    }

    // /**
    //  * @return LawArticles[] Returns an array of LawArticles objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LawArticles
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
