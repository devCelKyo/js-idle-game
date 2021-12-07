<?php

namespace App\Repository;

use App\Entity\ItemModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ItemModel|null find($id, $lockMode = null, $lockVersion = null)
 * @method ItemModel|null findOneBy(array $criteria, array $orderBy = null)
 * @method ItemModel[]    findAll()
 * @method ItemModel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemModelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ItemModel::class);
    }

    // /**
    //  * @return ItemModel[] Returns an array of ItemModel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ItemModel
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
