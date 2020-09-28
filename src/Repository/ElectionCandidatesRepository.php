<?php

namespace App\Repository;

use App\Entity\ElectionCandidates;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ElectionCandidates|null find($id, $lockMode = null, $lockVersion = null)
 * @method ElectionCandidates|null findOneBy(array $criteria, array $orderBy = null)
 * @method ElectionCandidates[]    findAll()
 * @method ElectionCandidates[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ElectionCandidatesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ElectionCandidates::class);
    }

    // /**
    //  * @return ElectionCandidates[] Returns an array of ElectionCandidates objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ElectionCandidates
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
