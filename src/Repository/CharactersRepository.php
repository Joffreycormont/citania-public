<?php

namespace App\Repository;

use App\Entity\Characters;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Null_;

/**
 * @method Characters|null find($id, $lockMode = null, $lockVersion = null)
 * @method Characters|null findOneBy(array $criteria, array $orderBy = null)
 * @method Characters[]    findAll()
 * @method Characters[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharactersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Characters::class);
    }

    public function findCharacter($id, $character)
    {
        $query = $this->createQueryBuilder('c')
            ->select('c','cpharmacy','cjob','dp', 'pp')

            ->leftJoin('c.pharmacy', 'cpharmacy')
            ->leftJoin('c.doctorPatients', 'dp')
            ->leftJoin('c.patients', 'pp')
            ->leftJoin('c.job', 'cjob');

            if($character->getJob() != null){
                if($character->getJob()->getSlug() == "medic"){
                    $query
                    ->addSelect('dpc')
                    ->addSelect('dpctruck')
                    ->addSelect('dpcpharmacy')
                    ->addSelect('dpcphardemands')
                    ->addSelect('dpcu')
                    ->addSelect('dpcprice')
                    ->addSelect('dpcpl')
                    ->addSelect('didpc')
                    ->addSelect('didpcdi')
                    ->addSelect('didpcditr')
                    ->leftJoin('dp.patient', 'dpc')
                    ->leftJoin('dpc.pharmacy', 'dpcpharmacy')
                    ->leftJoin('dpcpharmacy.pharmacyDemands', 'dpcphardemands')
                    ->leftJoin('dpc.truckWaste', 'dpctruck')
                    ->leftjoin('dpc.user', 'dpcu')
                    ->leftjoin('dpc.medicPriceSubscription', 'dpcprice')
                    ->leftJoin('dpc.profils', 'dpcpl')
                    ->leftJoin('dpc.diseaseCharacters', 'didpc')
                    ->leftJoin('didpc.disease', 'didpcdi')
                    ->leftJoin('didpcdi.treatment', 'didpcditr');
                }
            }

            $query->where('c.id = :id')
            ->setParameter(':id', $id);


            return $query->getQuery()
                    ->getResult();
    }

    public function getFirstnameList()
    {
        return $this->createQueryBuilder('c')
            ->select('c.firstname')
            ->getQuery()
            ->getResult();
    }

    public function getLastnameList()
    {
        return $this->createQueryBuilder('c')
            ->select('c.lastname')
            ->getQuery()
            ->getResult();
    }

    public function findByFactor()
    {
        return $this->createQueryBuilder('c')
            ->addSelect('u')
            ->addSelect('j')
            ->join('c.user', 'u')
            ->join('c.job', 'j')
            ->where('j.slug = :Facteur')
            ->andWhere(':now < (u.isConnected + 21600)')
            ->setParameter(':Facteur', 'facteur')
            ->setParameter('now', time())
            ->getQuery()
            ->getResult();
    }

    public function findBySearch($search)
    {
        return $this->createQueryBuilder('c')
            ->where('c.firstname LIKE :search')
            ->orWhere('c.lastname LIKE :search')
            ->setParameter(':search', '%'.$search.'%')
            ->getQuery()
            ->getResult();
    }

    public function getAllCharacterConnected()
    {
        return $this->createQueryBuilder('c')
        ->join('c.user', 'u')
        ->where(':now < (u.isConnected + 21600) ORDER BY RAND()')
        ->setParameter('now', time())
        ->getQuery()
        ->getResult();
    }


    public function getCharacterWithFilters($characterName, $filter, $jobName)
    {
        $query = 
        
        $this->createQueryBuilder('c')
        ->join('c.user', 'u')
        ->addSelect('j')
        ->leftjoin('c.job', 'j');
        
        if(!empty($characterName)){
            $query
                ->andWhere('c.firstname LIKE :characterName')
                ->orWhere('c.lastname LIKE :characterName')
                ->setParameter('characterName', '%'.$characterName.'%');
        }

        if(!empty($filter)){

            if($filter == 'coDESC'){
                $query->orderBy('u.UpdatedAt', 'ASC');
            }

            if($filter == 'coASC'){
                $query->orderBy('u.UpdatedAt', 'DESC');
            }

            if($filter == 'ageASC'){
                $query->orderBy('c.age', 'ASC');
            }

            if($filter == 'ageDESC'){
                $query->orderBy('c.age', 'DESC');
            }

            if($filter == 'nameDESC'){
                $query->orderBy('c.firstname', 'DESC');
            }

            if($filter == 'nameASC'){
                $query->orderBy('c.lastname', 'ASC');
            }
        
            if($filter == 'jobASC'){
                $query->orderBy('c.job', 'ASC');
            }

            if($filter == 'jobDESC'){
                $query->orderBy('c.job', 'DESC');
            }

        }

        if(!empty($jobName)){
            $query->andWhere('j.name = :jobName')
            ->setParameter('jobName', $jobName);
        }

        $query->andWhere(':now < (u.isConnected + 21600)')
              ->setParameter('now', time());
        
        return $query
                    ->getQuery()
                    ->getResult();
    }
    

    public function getAllUserConnectedByJob($job)
    {
        return $this->createQueryBuilder('c')
        ->addSelect('u')
        ->addSelect('j')
        ->join('c.user', 'u')
        ->join('c.job', 'j')
        ->where(':now < (u.isConnected + 21600)')
        ->andwhere('j.name = :job')
        ->setParameter('job', $job)
        ->setParameter('now', time())
        ->getQuery()
        ->getResult(); 
    }

    public function getLast25()
    {
        return $this->createQueryBuilder('c')
        ->addSelect('user')
        ->addSelect('profil')
        ->addSelect('truckWaste')
        ->addSelect('medicPriceSubscription')
        ->addSelect('pharmacy')
        ->addSelect('pharmacyDemand')
        ->addSelect('stampStock')
        ->leftjoin('c.profils', 'profil')
        ->leftjoin('c.user', 'user')
        ->leftjoin('c.truckWaste', 'truckWaste')
        ->leftJoin('c.medicPriceSubscription', 'medicPriceSubscription')
        ->leftjoin('c.pharmacy', 'pharmacy')
        ->leftjoin('c.pharmacyDemand', 'pharmacyDemand')
        ->leftjoin('c.stampStock', 'stampStock')
        ->orderBy('c.casinoGamePlayed', 'DESC')
        ->addOrderBy('c.casinoCoins', 'DESC')
        ->setMaxResults(15)
        ->getQuery()
        ->getResult(); 
    }

    public function getLast25P2()
    {
        return $this->createQueryBuilder('c')
        ->addSelect('user')
        ->addSelect('profil')
        ->addSelect('truckWaste')
        ->addSelect('medicPriceSubscription')
        ->addSelect('pharmacy')
        ->addSelect('pharmacyDemand')
        ->addSelect('stampStock')
        ->leftjoin('c.profils', 'profil')
        ->leftjoin('c.user', 'user')
        ->leftjoin('c.truckWaste', 'truckWaste')
        ->leftJoin('c.medicPriceSubscription', 'medicPriceSubscription')
        ->leftjoin('c.pharmacy', 'pharmacy')
        ->leftjoin('c.pharmacyDemand', 'pharmacyDemand')
        ->leftjoin('c.stampStock', 'stampStock')
        ->orderBy('c.casinoGamePlayed', 'DESC')
        ->addOrderBy('c.casinoCoins', 'DESC')
        ->setMaxResults(15)
        ->setFirstResult(15)
        ->getQuery()
        ->getResult(); 
    }

    // /**
    //  * @return Characters[] Returns an array of Characters objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Characters
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
