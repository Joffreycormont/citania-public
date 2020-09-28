<?php

namespace App\Repository;

use App\Entity\Diseases;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Diseases|null find($id, $lockMode = null, $lockVersion = null)
 * @method Diseases|null findOneBy(array $criteria, array $orderBy = null)
 * @method Diseases[]    findAll()
 * @method Diseases[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiseasesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Diseases::class);
    }

    // /**
    //  * @return Diseases[] Returns an array of Diseases objects
    //  */
    

    public function findByMediumAndEasy()
    {
        return $this->createQueryBuilder('d')
            ->Where('d.level = :easy')
            ->orWhere('d.level = :medium')
            ->setParameters(['easy' => 'easy', 'medium' => 'medium'])
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByHardAndOthers()
    {
        return $this->createQueryBuilder('d')
            ->Where('d.level = :easy')
            ->orWhere('d.level = :medium')
            ->orWhere('d.level = :hard')
            ->setParameters(['easy' => 'easy', 'medium' => 'medium', 'hard' => 'hard'])
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByHardPlusAndOthers()
    {
        return $this->createQueryBuilder('d')
            ->Where('d.level = :easy')
            ->orWhere('d.level = :medium')
            ->orWhere('d.level = :hard')
            ->orWhere('d.level = :hardPlus')
            ->setParameters(['easy' => 'easy', 'medium' => 'medium', 'hard' => 'hard', 'hardPlus' => 'hard++'])
            ->getQuery()
            ->getResult()
        ;
    }

    

    

    
    

    /*
    public function findOneBySomeField($value): ?Diseases
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
