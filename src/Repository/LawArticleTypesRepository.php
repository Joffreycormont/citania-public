<?php

namespace App\Repository;

use App\Entity\LawArticleTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LawArticleTypes|null find($id, $lockMode = null, $lockVersion = null)
 * @method LawArticleTypes|null findOneBy(array $criteria, array $orderBy = null)
 * @method LawArticleTypes[]    findAll()
 * @method LawArticleTypes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LawArticleTypesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LawArticleTypes::class);
    }

    // /**
    //  * @return LawArticleTypes[] Returns an array of LawArticleTypes objects
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
    public function findOneBySomeField($value): ?LawArticleTypes
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
