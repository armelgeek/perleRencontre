<?php

namespace App\Repository;

use App\Entity\CadeauSent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CadeauSent|null find($id, $lockMode = null, $lockVersion = null)
 * @method CadeauSent|null findOneBy(array $criteria, array $orderBy = null)
 * @method CadeauSent[]    findAll()
 * @method CadeauSent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CadeauSentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CadeauSent::class);
    }

    // /**
    //  * @return CadeauSent[] Returns an array of CadeauSent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CadeauSent
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
