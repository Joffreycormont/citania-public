<?php

namespace App\Repository;

use App\Entity\FriendRequests;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method FriendRequests|null find($id, $lockMode = null, $lockVersion = null)
 * @method FriendRequests|null findOneBy(array $criteria, array $orderBy = null)
 * @method FriendRequests[]    findAll()
 * @method FriendRequests[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FriendRequestsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FriendRequests::class);
    }

    // /**
    //  * @return FriendRequests[] Returns an array of FriendRequests objects
    //  */
    
    public function findByReceiverId($userId)
    {
        return $this->createQueryBuilder('f')
            ->Where('f.receiver = :val')
            ->orWhere('f.send = :val')
            ->setParameter('val', $userId)
            ->getQuery()
            ->getResult()
        ;
    }
    

    
    public function checkIfRequestExist($sendId, $receiverId)
    {
        return $this->createQueryBuilder('f')
            ->Where('f.receiver = :receiverId')
            ->andWhere('f.send = :sendId')
            ->setParameter('sendId', $sendId)
            ->setParameter('receiverId', $receiverId)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByReceiverIdWaiting($userId)
    {
        return $this->createQueryBuilder('f')
            ->Where('f.receiver = :val')
            ->andWhere('f.status = 0')
            ->setParameter('val', $userId)
            ->getQuery()
            ->getResult()
        ;
    }
    
}
