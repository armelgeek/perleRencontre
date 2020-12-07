<?php

namespace App\Repository;

use App\Entity\PhotoCouverture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PhotoCouverture|null find($id, $lockMode = null, $lockVersion = null)
 * @method PhotoCouverture|null findOneBy(array $criteria, array $orderBy = null)
 * @method PhotoCouverture[]    findAll()
 * @method PhotoCouverture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoCouvertureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PhotoCouverture::class);
    }
    public function PhotoCouvertureActive($user)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.isActive = true')
            ->andWhere('p.utilisateur = :user')
            ->setParameter('user', $user)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    // /**
    //  * @return PhotoCouverture[] Returns an array of PhotoCouverture objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PhotoCouverture
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
