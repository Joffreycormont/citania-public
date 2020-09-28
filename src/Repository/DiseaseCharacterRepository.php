<?php

namespace App\Repository;

use App\Entity\DiseaseCharacter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method DiseaseCharacter|null find($id, $lockMode = null, $lockVersion = null)
 * @method DiseaseCharacter|null findOneBy(array $criteria, array $orderBy = null)
 * @method DiseaseCharacter[]    findAll()
 * @method DiseaseCharacter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiseaseCharacterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DiseaseCharacter::class);
    }

    // /**
    //  * @return DiseaseCharacter[] Returns an array of DiseaseCharacter objects
    //  */
    
    public function checkIfAlreadyhaveDisease($value, $character)
    {
        return $this->createQueryBuilder('d')
            ->Where('d.disease = :val')
            ->andWhere('d.characters = :character')
            ->setParameter('val', $value)
            ->setParameter('character', $character)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?DiseaseCharacter
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
