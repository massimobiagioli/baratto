<?php

namespace App\Repository;

use App\Entity\Movimento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Movimento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Movimento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Movimento[]    findAll()
 * @method Movimento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovimentoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Movimento::class);
    }

    // /**
    //  * @return Movimento[] Returns an array of Movimento objects
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
    public function findOneBySomeField($value): ?Movimento
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
