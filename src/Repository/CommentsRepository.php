<?php

namespace App\Repository;

use App\Entity\Comments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Comments|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comments|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comments[]    findAll()
 * @method Comments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comments::class);
    }

    // /**
    //  * @return Query
    //  */
    
    public function findByDesc($userId): Query
    {
        return $this->createQueryBuilder('c')
            ->where('c.characters = :val')
            ->setParameter('val', $userId)
            ->orderBy('c.createdAt', 'DESC')
            ->getQuery()
        ;
    }

    public function findWaitingComments($userId)
    {
        return $this->createQueryBuilder('c')
            ->where('c.status = :val')
            ->andWhere('c.characters = :userId')
            ->setParameter('val', 0)
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Comments
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
