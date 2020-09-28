<?php

namespace App\Repository;

use App\Entity\ObjectEffect;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ObjectEffect|null find($id, $lockMode = null, $lockVersion = null)
 * @method ObjectEffect|null findOneBy(array $criteria, array $orderBy = null)
 * @method ObjectEffect[]    findAll()
 * @method ObjectEffect[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjectEffectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ObjectEffect::class);
    }

    // /**
    //  * @return ObjectEffect[] Returns an array of ObjectEffect objects
    //  */
    
    public function findByProductname($product)
    {
        return $this->createQueryBuilder('o')
            ->Where('o.objectName = :product')
            ->setParameter('product', $product)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?ObjectEffect
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
