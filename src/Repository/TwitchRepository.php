<?php

namespace App\Repository;

use App\Entity\Twitch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Twitch|null find($id, $lockMode = null, $lockVersion = null)
 * @method Twitch|null findOneBy(array $criteria, array $orderBy = null)
 * @method Twitch[]    findAll()
 * @method Twitch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TwitchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Twitch::class);
    }

    // /**
    //  * @return Twitch[] Returns an array of Twitch objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Twitch
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
