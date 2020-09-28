<?php

namespace App\Repository;

use App\Entity\StudiesTest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method StudiesTest|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudiesTest|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudiesTest[]    findAll()
 * @method StudiesTest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudiesTestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudiesTest::class);
    }

    // /**
    //  * @return StudiesTest[] Returns an array of StudiesTest objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StudiesTest
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
