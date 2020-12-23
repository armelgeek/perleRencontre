<?php

namespace App\Repository;

use App\Entity\AutorisedUser;
use App\Entity\Utilisateur;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AutorisedUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method AutorisedUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method AutorisedUser[]    findAll()
 * @method AutorisedUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AutorisedUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AutorisedUser::class);
    }

    public function findByUser(Utilisateur $user,Utilisateur $receiver): ?AutorisedUser{
        return $this->createQueryBuilder('a')
            ->andWhere('a.user = :user')
            ->orWhere('a.receiver = :receiver')
            ->andWhere('a.isAutorised = :access')
            ->orWhere('a.expiredAt != null ')
            ->andWhere('a.expiredAt > :now')
            ->setParameter('user', $user)
            ->setParameter('receiver', $receiver)
            ->setParameter('access', true)
            ->setParameter('now', new DateTime())
            ->getQuery()
            ->getOneOrNullResult();
    }
}
