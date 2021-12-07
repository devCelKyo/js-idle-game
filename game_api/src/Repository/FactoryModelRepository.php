<?php

namespace App\Repository;

use App\Entity\FactoryModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FactoryModel|null find($id, $lockMode = null, $lockVersion = null)
 * @method FactoryModel|null findOneBy(array $criteria, array $orderBy = null)
 * @method FactoryModel[]    findAll()
 * @method FactoryModel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FactoryModelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FactoryModel::class);
    }

    // /**
    //  * @return FactoryModel[] Returns an array of FactoryModel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FactoryModel
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
