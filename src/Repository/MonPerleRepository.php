<?php

namespace App\Repository;

use App\Entity\MonPerle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MonPerle|null find($id, $lockMode = null, $lockVersion = null)
 * @method MonPerle|null findOneBy(array $criteria, array $orderBy = null)
 * @method MonPerle[]    findAll()
 * @method MonPerle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonPerleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MonPerle::class);
    }

    // /**
    //  * @return MonPerle[] Returns an array of MonPerle objects
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
    public function findOneBySomeField($value): ?MonPerle
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
