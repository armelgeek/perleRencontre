<?php

namespace App\Repository;

use App\Entity\MonProfil;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MonProfil|null find($id, $lockMode = null, $lockVersion = null)
 * @method MonProfil|null findOneBy(array $criteria, array $orderBy = null)
 * @method MonProfil[]    findAll()
 * @method MonProfil[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonProfilRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MonProfil::class);
    }


    public function getByUserId($value): ?MonProfil
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.user_id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }
}