<?php

namespace App\Repository;

use App\Entity\FactorPrimes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FactorPrimes|null find($id, $lockMode = null, $lockVersion = null)
 * @method FactorPrimes|null findOneBy(array $criteria, array $orderBy = null)
 * @method FactorPrimes[]    findAll()
 * @method FactorPrimes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FactorPrimesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FactorPrimes::class);
    }

    // /**
    //  * @return FactorPrimes[] Returns an array of FactorPrimes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FactorPrimes
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
