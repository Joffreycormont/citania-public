<?php

namespace App\Repository;

use App\Entity\Humor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Humor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Humor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Humor[]    findAll()
 * @method Humor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HumorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Humor::class);
    }

    // /**
    //  * @return Humor[] Returns an array of Humor objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Humor
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
