<?php

namespace App\Repository;

use App\Entity\CommandPremium;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method CommandPremium|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandPremium|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandPremium[]    findAll()
 * @method CommandPremium[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandPremiumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommandPremium::class);
    }

    // /**
    //  * @return CommandPremium[] Returns an array of CommandPremium objects
    //  */
    
    public function findByUser($userId): ?Query
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.user = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('c.id', 'DESC')
            ->getQuery()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?CommandPremium
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
