<?php

namespace App\Repository;

use App\Entity\LawCodes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method LawCodes|null find($id, $lockMode = null, $lockVersion = null)
 * @method LawCodes|null findOneBy(array $criteria, array $orderBy = null)
 * @method LawCodes[]    findAll()
 * @method LawCodes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LawCodesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LawCodes::class);
    }

    // /**
    //  * @return LawCodes[] Returns an array of LawCodes objects
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
    public function findOneBySomeField($value): ?LawCodes
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
