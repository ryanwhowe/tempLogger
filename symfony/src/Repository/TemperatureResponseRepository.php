<?php

namespace App\Repository;

use App\Entity\TemperatureResponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TemperatureResponse|null find($id, $lockMode = null, $lockVersion = null)
 * @method TemperatureResponse|null findOneBy(array $criteria, array $orderBy = null)
 * @method TemperatureResponse[]    findAll()
 * @method TemperatureResponse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TemperatureResponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TemperatureResponse::class);
    }

    // /**
    //  * @return TemperatureResponse[] Returns an array of TemperatureResponse objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TemperatureResponse
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
