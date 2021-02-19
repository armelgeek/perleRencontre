<?php

namespace App\Repository;

use App\Entity\Chat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Chat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chat[]    findAll()
 * @method Chat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chat::class);
    }

    // /**
    //  * @return Chat[] Returns an array of Chat objects
    //  */
    // public function findConversation($id1,$id2)
    // {
    //     return $this->createQueryBuilder('c')
    //         ->leftJoin('c.conv','conv')
    //         ->andWhere('c.uti2 = :id2 AND c.uti1 = :id1')
    //         ->orWhere('c.uti1 = :id2 AND c.uti2 = :id1')
    //         ->setParameter('id1', $id1)
    //         ->setParameter('id2', $id2)
    //         ->getQuery()
    //         ->getOneOrNullResult()
    //     ;
    // }

    /*
    public function findOneBySomeField($value): ?Chat
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
