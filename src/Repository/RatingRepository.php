<?php

namespace App\Repository;

use App\Entity\Rating;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Rating|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rating|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rating[]    findAll()
 * @method Rating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RatingRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Rating::class);
    }

    public function getRatedByUserId(Int $id){

        return $this->createQueryBuilder('r')
            ->innerJoin('r.conferenceId', 'c')
            ->addSelect('c')
            ->andWhere('r.userId = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }


    public function getAverageConference(){

        return $this->createQueryBuilder('r')
            ->innerJoin('r.conferenceId', 'c')
            ->addSelect('c')
            ->addSelect('count(r.conferenceId)')
            ->addSelect( 'SUM(r.rate)')
            ->groupBy('r.conferenceId')
            ->getQuery()
            ->getResult();
    }
    // /**
    //  * @return Rating[] Returns an array of Rating objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Rating
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
