<?php

namespace App\Repository;

use App\Entity\SportsRoom;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SportsRoom|null find($id, $lockMode = null, $lockVersion = null)
 * @method SportsRoom|null findOneBy(array $criteria, array $orderBy = null)
 * @method SportsRoom[]    findAll()
 * @method SportsRoom[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SportsRoomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SportsRoom::class);
    }

    // /**
    //  * @return SportsRoom[] Returns an array of SportsRoom objects
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
    public function findOneBySomeField($value): ?SportsRoom
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
