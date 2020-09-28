<?php

namespace App\Repository;

use App\Entity\Patient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Patient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Patient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Patient[]    findAll()
 * @method Patient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PatientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Patient::class);
    }

    // /**
    //  * @return Patient[] Returns an array of Patient objects
    //  */
    
    public function findBySubscriptionAndMedic($medicCharacter)
    {
        return $this->createQueryBuilder('p')
            ->where('p.haveSubscription = 1')
            ->andWhere('p.doctor = :medicCharacter')
            ->setParameter('medicCharacter', $medicCharacter)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findPatientByMedic($medicCharacter)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.doctor = :medicCharacter')
            ->setParameter('medicCharacter', $medicCharacter)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findPatientConsultationByMedic($medicCharacter)
    {
        return count($this->createQueryBuilder('p')
            ->where('p.haveSubscription = 0')
            ->andWhere('p.doctor = :medicCharacter')
            ->setParameter('medicCharacter', $medicCharacter)
            ->getQuery()
            ->getResult())
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Patient
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
