<?php

namespace App\Repository;

use App\Entity\AbonnementCommand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AbonnementCommand|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbonnementCommand|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbonnementCommand[]    findAll()
 * @method AbonnementCommand[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbonnementCommandRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AbonnementCommand::class);
    }

    // /**
    //  * @return AbonnementCommand[] Returns an array of AbonnementCommand objects
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
    public function findOneBySomeField($value): ?AbonnementCommand
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
