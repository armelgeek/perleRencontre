<?php

namespace App\Repository;

use App\Entity\MonEnvie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MonEnvie|null find($id, $lockMode = null, $lockVersion = null)
 * @method MonEnvie|null findOneBy(array $criteria, array $orderBy = null)
 * @method MonEnvie[]    findAll()
 * @method MonEnvie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonEnvieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MonEnvie::class);
    }

    // /**
    //  * @return MonEnvie[] Returns an array of MonEnvie objects
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
    public function findOneBySomeField($value): ?MonEnvie
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
