<?php

namespace App\Repository;

use App\Entity\MessagePerle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MessagePerle|null find($id, $lockMode = null, $lockVersion = null)
 * @method MessagePerle|null findOneBy(array $criteria, array $orderBy = null)
 * @method MessagePerle[]    findAll()
 * @method MessagePerle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessagePerleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MessagePerle::class);
    }

    // /**
    //  * @return MessagePerle[] Returns an array of MessagePerle objects
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
    public function findOneBySomeField($value): ?MessagePerle
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
