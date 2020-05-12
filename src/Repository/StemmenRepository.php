<?php

namespace App\Repository;

use App\Entity\Stem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Stem|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stem|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stem[]    findAll()
 * @method Stem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StemmenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stem::class);
    }

    // /**
    //  * @return Stem[] Returns an array of Stem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stem
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
