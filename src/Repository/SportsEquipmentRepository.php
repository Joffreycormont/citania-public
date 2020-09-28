<?php

namespace App\Repository;

use App\Entity\SportsEquipment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SportsEquipment|null find($id, $lockMode = null, $lockVersion = null)
 * @method SportsEquipment|null findOneBy(array $criteria, array $orderBy = null)
 * @method SportsEquipment[]    findAll()
 * @method SportsEquipment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SportsEquipmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SportsEquipment::class);
    }

    // /**
    //  * @return SportsEquipment[] Returns an array of SportsEquipment objects
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
    public function findOneBySomeField($value): ?SportsEquipment
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
