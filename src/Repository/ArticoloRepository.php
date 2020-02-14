<?php

namespace App\Repository;

use App\Entity\Articolo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Articolo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Articolo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Articolo[]    findAll()
 * @method Articolo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticoloRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Articolo::class);
    }

    // /**
    //  * @return Articolo[] Returns an array of Articolo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Articolo
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
