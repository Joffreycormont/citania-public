<?php

namespace App\Repository;

use App\Entity\HouseFurniture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method HouseFurniture|null find($id, $lockMode = null, $lockVersion = null)
 * @method HouseFurniture|null findOneBy(array $criteria, array $orderBy = null)
 * @method HouseFurniture[]    findAll()
 * @method HouseFurniture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HouseFurnitureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HouseFurniture::class);
    }

    // /**
    //  * @return HouseFurniture[] Returns an array of HouseFurniture objects
    //  */
    

    public function findByHouse($houseId)
    {
        return $this->createQueryBuilder('hf')
            ->addSelect('h')
            ->join('hf.houses', 'h')
            ->Where('h = :houseId')
            ->setParameter('houseId', $houseId)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?HouseFurniture
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
