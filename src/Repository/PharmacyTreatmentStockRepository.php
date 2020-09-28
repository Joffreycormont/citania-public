<?php

namespace App\Repository;

use App\Entity\PharmacyTreatmentStock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PharmacyTreatmentStock|null find($id, $lockMode = null, $lockVersion = null)
 * @method PharmacyTreatmentStock|null findOneBy(array $criteria, array $orderBy = null)
 * @method PharmacyTreatmentStock[]    findAll()
 * @method PharmacyTreatmentStock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PharmacyTreatmentStockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PharmacyTreatmentStock::class);
    }

    // /**
    //  * @return PharmacyTreatmentStock[] Returns an array of PharmacyTreatmentStock objects
    //  */
    
    public function findByPharmacyAndTreatment($pharmacy, $treatment)
    {
        return $this->createQueryBuilder('p')
            ->where('p.treatment = :treatment')
            ->andWhere('p.pharmacy = :pharmacy')
            ->setParameter('treatment', $treatment)
            ->setParameter('pharmacy', $pharmacy)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?PharmacyTreatmentStock
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
