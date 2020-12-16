<?php

namespace App\Repository;

use App\Entity\Abonnement;
use App\Entity\AbonnementComand;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Utilisateur;
use DateTime;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

/**
 * @method Abonnement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Abonnement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Abonnement[]    findAll()
 * @method Abonnement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbonnementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Abonnement::class);
    }

    public function getInfos(UserInterface $user)
    {
        if (!$user instanceof Utilisateur) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }
        $abonnement = $user->getAbonnement();
        return $abonnement;
    }


    public function upgradeAbonnement(UserInterface $user, String $type)
    {
        if (!$user instanceof Utilisateur) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }
        $abonnement = $user->getAbonnement();
        $diffDate = $abonnement->getExpiredAt()->diff(DateTime::createFromFormat('Y-m-d H:i:s', strtotime('now')));
        if ($diffDate->days <= 0) {

            // Verify type
            // type 1 => 100 perles,
            // type 2 => 250 perles

            $monperle = $user->getMonperle();
            $abonnement->setType($type);
            $dateImmutable = \DateTime::createFromFormat('Y-m-d H:i:s', strtotime('now +30 days'));
            $abonnement->setExpiredAt($dateImmutable);
            $this->_em->persist($abonnement);
            $this->_em->flush();
            return true;
        } else {
            return false;
        }
    }

    // /**
    //  * @return Abonnement[] Returns an array of Abonnement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Abonnement
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}