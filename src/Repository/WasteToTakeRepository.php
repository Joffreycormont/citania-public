<?php

namespace App\Repository;

use App\Entity\WasteToTake;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method WasteToTake|null find($id, $lockMode = null, $lockVersion = null)
 * @method WasteToTake|null findOneBy(array $criteria, array $orderBy = null)
 * @method WasteToTake[]    findAll()
 * @method WasteToTake[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WasteToTakeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WasteToTake::class);
    }

    // /**
    //  * @return WasteToTake[] Returns an array of WasteToTake objects
    //  */
    
    public function checkWasteRequest($user)
    {
        return $this->createQueryBuilder('w')
            ->addSelect('c')
            ->join('w.characters', 'c')
            ->Where('c = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?WasteToTake
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
