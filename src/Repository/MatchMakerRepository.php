<?php

namespace App\Repository;

use App\Entity\MatchMaker;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MatchMaker|null find($id, $lockMode = null, $lockVersion = null)
 * @method MatchMaker|null findOneBy(array $criteria, array $orderBy = null)
 * @method MatchMaker[]    findAll()
 * @method MatchMaker[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatchMakerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MatchMaker::class);
    }

    // /**
    //  * @return MatchMaker[] Returns an array of MatchMaker objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MatchMaker
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
