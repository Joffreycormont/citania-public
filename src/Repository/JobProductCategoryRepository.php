<?php

namespace App\Repository;

use App\Entity\JobProductCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method JobProductCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobProductCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobProductCategory[]    findAll()
 * @method JobProductCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobProductCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobProductCategory::class);
    }

    // /**
    //  * @return JobProductCategory[] Returns an array of JobProductCategory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?JobProductCategory
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
