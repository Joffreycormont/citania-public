<?php

namespace App\Repository;

use App\Entity\MedicPriceSubscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method MedicPriceSubscription|null find($id, $lockMode = null, $lockVersion = null)
 * @method MedicPriceSubscription|null findOneBy(array $criteria, array $orderBy = null)
 * @method MedicPriceSubscription[]    findAll()
 * @method MedicPriceSubscription[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedicPriceSubscriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MedicPriceSubscription::class);
    }

    // /**
    //  * @return MedicPriceSubscription[] Returns an array of MedicPriceSubscription objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MedicPriceSubscription
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
