<?php

namespace App\Repository;

use App\Entity\Childrens;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Childrens|null find($id, $lockMode = null, $lockVersion = null)
 * @method Childrens|null findOneBy(array $criteria, array $orderBy = null)
 * @method Childrens[]    findAll()
 * @method Childrens[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChildrensRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Childrens::class);
    }

    // /**
    //  * @return Childrens[] Returns an array of Childrens objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Childrens
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
