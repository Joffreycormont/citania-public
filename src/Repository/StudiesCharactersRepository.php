<?php

namespace App\Repository;

use App\Entity\StudiesCharacters;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method StudiesCharacters|null find($id, $lockMode = null, $lockVersion = null)
 * @method StudiesCharacters|null findOneBy(array $criteria, array $orderBy = null)
 * @method StudiesCharacters[]    findAll()
 * @method StudiesCharacters[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudiesCharactersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudiesCharacters::class);
    }

    // /**
    //  * @return StudiesCharacters[] Returns an array of StudiesCharacters objects
    //  */
    
    public function checkIfHasDiplome($job, $character)
    {
        return $this->createQueryBuilder('s')
            ->addSelect('std')
            ->join('s.study', 'std')
            ->addSelect('j')
            ->join('std.job', 'j')
            ->Where('s.status = 1')
            ->andWhere('s.Characters = :character')
            ->andWhere('j.id = :job')
            ->setParameter('character', $character)
            ->setParameter('job', $job->getId())
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByStudyAndStatus($studyId, $character)
    {
        return $this->createQueryBuilder('s')
        ->addSelect('std')
        ->join('s.study', 'std')
        ->Where('s.status = 1')
        ->andWhere('s.Characters = :character')
        ->andWhere('std.id = :id')
        ->setParameter('id', $studyId)
        ->setParameter('character', $character)
        ->getQuery()
        ->getResult()
        ;
    }

    public function findByCharacterAndStatus($character)
    {
        return $this->createQueryBuilder('s')
        ->Where('s.status = 0')
        ->andWhere('s.Characters = :character')
        ->setParameter('character', $character)
        ->getQuery()
        ->getResult()
        ;
    }

    public function findByStudyAndStatusZero($studyId, $character)
    {
        return $this->createQueryBuilder('s')
        ->addSelect('std')
        ->join('s.study', 'std')
        ->Where('s.status = 0')
        ->andWhere('s.Characters = :character')
        ->andWhere('std.id = :id')
        ->setParameter('id', $studyId)
        ->setParameter('character', $character)
        ->getQuery()
        ->getResult()
        ;
    }

    public function checkIfAlreadyHave($study, $character)
    {
        return $this->createQueryBuilder('s')
        ->addSelect('std')
        ->join('s.study', 'std')
        ->Where('s.Characters = :character')
        ->andWhere('s.study = :study')
        ->setParameter('study', $study)
        ->setParameter('character', $character)
        ->getQuery()
        ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?StudiesCharacters
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
