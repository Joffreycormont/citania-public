<?php

namespace App\Repository;

use App\Entity\ObjectCharacter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ObjectCharacter|null find($id, $lockMode = null, $lockVersion = null)
 * @method ObjectCharacter|null findOneBy(array $criteria, array $orderBy = null)
 * @method ObjectCharacter[]    findAll()
 * @method ObjectCharacter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ObjectCharacterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ObjectCharacter::class);
    }

    // /**
    //  * @return ObjectCharacter[] Returns an array of ObjectCharacter objects
    //  */
    
    public function checkIfObjectAlreadyExist($characterId, $product)
    {
        return $this->createQueryBuilder('o')
            ->Where('o.characters = :characterid')
            ->andWhere('o.name = :product')
            ->setParameter('characterid', $characterId)
            ->setParameter('product', $product)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?ObjectCharacter
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
