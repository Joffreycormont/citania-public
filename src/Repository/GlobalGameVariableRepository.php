<?php

namespace App\Repository;

use App\Entity\GlobalGameVariable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method GlobalGameVariable|null find($id, $lockMode = null, $lockVersion = null)
 * @method GlobalGameVariable|null findOneBy(array $criteria, array $orderBy = null)
 * @method GlobalGameVariable[]    findAll()
 * @method GlobalGameVariable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GlobalGameVariableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GlobalGameVariable::class);
    }

    // /**
    //  * @return GlobalGameVariable[] Returns an array of GlobalGameVariable objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?GlobalGameVariable
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
