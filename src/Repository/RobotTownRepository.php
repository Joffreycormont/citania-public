<?php

namespace App\Repository;

use App\Entity\RobotTown;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method RobotTown|null find($id, $lockMode = null, $lockVersion = null)
 * @method RobotTown|null findOneBy(array $criteria, array $orderBy = null)
 * @method RobotTown[]    findAll()
 * @method RobotTown[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RobotTownRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RobotTown::class);
    }

    // /**
    //  * @return RobotTown[] Returns an array of RobotTown objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RobotTown
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
