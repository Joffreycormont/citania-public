<?php

namespace App\Repository;

use App\Entity\Logbook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Logbook|null find($id, $lockMode = null, $lockVersion = null)
 * @method Logbook|null findOneBy(array $criteria, array $orderBy = null)
 * @method Logbook[]    findAll()
 * @method Logbook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogbookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Logbook::class);
    }

    // /**
    //  * @return Logbook[] Returns an array of Logbook objects
    //  */
    
    public function findByReceiver($userId): Query
    {
        return $this->createQueryBuilder('l')
            ->Where('l.characters = :userId')
            ->setParameter('userId', $userId)
            ->orderBy('l.id', 'DESC')
            ->getQuery()
        ;
    }

    public function getUnReadEvent($userId)
    {
        return $this->createQueryBuilder('l')
            ->Where('l.characters = :userId')
            ->andWhere('l.status = 0')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Logbook
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
