<?php

namespace App\Repository;

use App\Entity\MonCoffre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MonCoffre|null find($id, $lockMode = null, $lockVersion = null)
 * @method MonCoffre|null findOneBy(array $criteria, array $orderBy = null)
 * @method MonCoffre[]    findAll()
 * @method MonCoffre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonCoffreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MonCoffre::class);
    }

    // /**
    //  * @return MonCoffre[] Returns an array of MonCoffre objects
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
    public function findOneBySomeField($value): ?MonCoffre
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
