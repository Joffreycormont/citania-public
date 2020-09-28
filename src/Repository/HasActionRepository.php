<?php

namespace App\Repository;

use App\Entity\HasAction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method HasAction|null find($id, $lockMode = null, $lockVersion = null)
 * @method HasAction|null findOneBy(array $criteria, array $orderBy = null)
 * @method HasAction[]    findAll()
 * @method HasAction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HasActionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HasAction::class);
    }

    // /**
    //  * @return HasAction[] Returns an array of HasAction objects
    //  */
    
    public function checkAction($actionId, $sendId, $receiverId)
    {
        return $this->createQueryBuilder('h')
            ->where('h.action = :actionId')
            ->andWhere('h.send = :sendId')
            ->andWhere('h.receiver = :receiverId')
            ->setParameter('actionId', $actionId)
            ->setParameter('sendId', $sendId)
            ->setParameter('receiverId', $receiverId)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?HasAction
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
