<?php

namespace App\Repository;

use App\Entity\Utente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Utente|null find($id, $lockMode = null, $lockVersion = null)
 * @method Utente|null findOneBy(array $criteria, array $orderBy = null)
 * @method Utente[]    findAll()
 * @method Utente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtenteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Utente::class);
    }

    // /**
    //  * @return Utente[] Returns an array of Utente objects
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
    public function findOneBySomeField($value): ?Utente
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
