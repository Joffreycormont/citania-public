<?php

namespace App\Repository;

use App\Entity\Messages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * @method Messages|null find($id, $lockMode = null, $lockVersion = null)
 * @method Messages|null findOneBy(array $criteria, array $orderBy = null)
 * @method Messages[]    findAll()
 * @method Messages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Messages::class);
    }

    // /**
    //  * @return Query
    //  */
    
    public function getMessageListWithLastMessageFirst($userReceiverId): Query
    {
        return $this->createQueryBuilder('m')
            ->Where('m.receiverId = :userReceiverId')
            ->orWhere('m.send = :userReceiverId')
            ->andWhere('m.last = 1')
            ->setParameter('userReceiverId', $userReceiverId)
            ->orderBy('m.id', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            //->getResult()
        ;
    }

    public function getLastMessageForReceiver($userReceiverId)
    {
        return $this->createQueryBuilder('m')
            ->Where('m.receiverId = :userReceiverId')
            ->andWhere('m.last = 1')
            ->andWhere('m.status = 1')
            ->setParameter('userReceiverId', $userReceiverId)
            ->getQuery()
            ->getResult()
        ;
    }

    public function getMessageForDiscussion($userReceiverId, $sendId)
    {
        return $this->createQueryBuilder('m')
            ->Where('m.receiverId = :userReceiverId')
            ->orWhere('m.receiverId = :sendId')
            ->andWhere('m.send = :sendId')
            ->orWhere('m.send = :userReceiverId')
            ->setParameter('userReceiverId', $userReceiverId)
            ->setParameter('sendId', $sendId)
            ->orderBy('m.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getLastMessageDiscussion($userReceiverId, $sendId)
    {
               /* SELECT * FROM `messages` 
        WHERE `receiver_id`= 4 AND `send_id`= 1 
        OR receiver_id = 1 AND send_id= 4
        AND last=1*/
    
        // returns an array of arrays (i.e. a raw data set)
        return $this->createQueryBuilder('m')

            ->Where('m.receiverId = :sendId')
            ->andWhere('m.send = :userReceiverId')

            ->orWhere('m.receiverId = :userReceiverId')
            ->andWhere('m.send = :sendId')

            ->setParameter('userReceiverId', $userReceiverId)
            ->setParameter('sendId', $sendId)

            ->andWhere('m.last = 1')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getLastMessageDiscussionForReaded($userReceiverId, $sendId)
    {
               /* SELECT * FROM `messages` 
        WHERE `receiver_id`= 4 AND `send_id`= 1 
        OR receiver_id = 1 AND send_id= 4
        AND last=1*/
    
        // returns an array of arrays (i.e. a raw data set)
        return $this->createQueryBuilder('m')

            ->Where('m.receiverId = :userReceiverId')
            ->andWhere('m.send = :sendId')
            
            ->setParameter('userReceiverId', $userReceiverId)
            ->setParameter('sendId', $sendId)

            ->andWhere('m.status = 1')
            ->getQuery()
            ->getResult()
        ;
    }


    

    /*
    public function findOneBySomeField($value): ?Messages
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
