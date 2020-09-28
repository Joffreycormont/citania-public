<?php

namespace App\Repository;

use App\Entity\TestAnswers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TestAnswers|null find($id, $lockMode = null, $lockVersion = null)
 * @method TestAnswers|null findOneBy(array $criteria, array $orderBy = null)
 * @method TestAnswers[]    findAll()
 * @method TestAnswers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestAnswersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TestAnswers::class);
    }

    // /**
    //  * @return TestAnswers[] Returns an array of TestAnswers objects
    //  */
    
    public function checkIfIsGoodAnswer($id, $questionId)
    {
        return $this->createQueryBuilder('t')
            ->addSelect('q')
            ->join('t.question', 'q')
            ->Where('t.id = :id')
            ->andWhere('q.id = :questionId')
            ->andWhere('t.isGoodAnswer = 1')
            ->setParameter('id', $id)
            ->setParameter('questionId', $questionId)
            ->getQuery()
            ->getResult()
        ;
    }   
    

    
    public function checkHowManyGoodAnswersRequired($questionId)
    {
        return count($this->createQueryBuilder('t')
            ->addSelect('q')
            ->join('t.question', 'q')
            ->Where('q.id = :val')
            ->andWhere('t.isGoodAnswer = 1')
            ->setParameter('val', $questionId)
            ->getQuery()
            ->getResult())
        ;
    }
    
}
