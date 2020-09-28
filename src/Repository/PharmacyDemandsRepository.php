<?php

namespace App\Repository;

use App\Entity\PharmacyDemands;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PharmacyDemands|null find($id, $lockMode = null, $lockVersion = null)
 * @method PharmacyDemands|null findOneBy(array $criteria, array $orderBy = null)
 * @method PharmacyDemands[]    findAll()
 * @method PharmacyDemands[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PharmacyDemandsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PharmacyDemands::class);
    }

    // /**
    //  * @return PharmacyDemands[] Returns an array of PharmacyDemands objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PharmacyDemands
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
