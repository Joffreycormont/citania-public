<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    
    public function getEmailList()
    {
        return $this->createQueryBuilder('u')
            ->select('u.email')
            ->getQuery()
            ->getResult();
    }

    public function getAllUserConnected()
    {
        /*return $this->createQueryBuilder('u')
            ->where(':now < (u.isConnected + 21600)')
            ->setParameter('now', time())
            ->getQuery();*/

            $rsm = new \Doctrine\ORM\Query\ResultSetMappingBuilder($this->getEntityManager());
            $rsm->addRootEntityFromClassMetadata(\App\Entity\User::class, 'user');
            $sql = "SELECT * FROM user WHERE ".time()." < (is_connected + 21600) ORDER BY RAND()";
            return $this->getEntityManager()->createNativeQuery($sql, $rsm)->getResult();

    }

    public function findUserIdByEmail($email)
    {
        return $this->createQueryBuilder('u')
        ->select('u.id')
        ->where('u.email = :email')
        ->setParameter('email', $email)
        ->getQuery()
        ->getResult(); 
    }


    public function findWithFilters($id, $email, $firstname, $lastname, $age, $job)
    {
        $query = $this->createQueryBuilder('u');

        if(!empty($id)){
            $query->andwhere('u.id LIKE :id')
            ->setParameter('id', $id.'%');
        }

        if(!empty($email)){
            $query->andwhere('u.email LIKE :email')
            ->setParameter('email', $email.'%');
        }

        if(!empty($firstname)){
            $query
            ->addSelect('c')
            ->join('u.characters', 'c')
            ->andwhere('c.firstname LIKE :firstname')
            ->setParameter('firstname', $firstname.'%');
        }

        if(!empty($lastname)){
            $query
            ->addSelect('c')
            ->join('u.characters', 'c')
            ->andwhere('c.lastname LIKE :lastname')
            ->setParameter('lastname', $lastname.'%');
        }

        if(!empty($age)){
            $query
            ->addSelect('c')
            ->join('u.characters', 'c')
            ->andwhere('c.age LIKE :age')
            ->setParameter('age', $age.'%');
        }

        if(!empty($job)){
            $query
            ->addSelect('c')
            ->join('u.characters', 'c')
            ->addSelect('j')
            ->join('c.job', 'j')
            ->andwhere('j.name LIKE :job')
            ->setParameter('job', $job.'%');
        }

        return $query->getQuery()->getResult(); 
    }


    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
