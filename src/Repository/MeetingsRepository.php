<?php

namespace App\Repository;

use App\Entity\Meetings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Meetings|null find($id, $lockMode = null, $lockVersion = null)
 * @method Meetings|null findOneBy(array $criteria, array $orderBy = null)
 * @method Meetings[]    findAll()
 * @method Meetings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MeetingsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Meetings::class);
    }

//    /**
//     * @return Meetings[] Returns an array of Meetings objects
//     */
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
    public function findOneBySomeField($value): ?Meetings
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
