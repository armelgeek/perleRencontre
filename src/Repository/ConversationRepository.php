<?php

namespace App\Repository;

use App\Entity\Conversation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Conversation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conversation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conversation[]    findAll()
 * @method Conversation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConversationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conversation::class);
    }

    public function getMessages($id)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.messages','m')
            ->leftJoin('m.uti','u')
            ->andWhere('c.id = :id')
            ->setParameter('id', $id)
            // ->select('m.id,m.type,m.message, m.chapitre,m.createdAt','m.updatedAt')
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findConversation($id1, $id2)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.chat', 'chat')
            ->andWhere('chat.uti2 = :id2 AND chat.uti1 = :id1')
            ->orWhere('chat.uti1 = :id2 AND chat.uti2 = :id1')
            ->setParameter('id1', $id1)
            ->setParameter('id2', $id2)
            ->getQuery()
            ->getOneOrNullResult();
    }


    /*
    public function findOneBySomeField($value): ?Conversation
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
