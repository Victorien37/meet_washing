<?php

namespace App\Repository;

use App\Entity\VehiculeType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VehiculeType>
 */
class VehiculeTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VehiculeType::class);
    }

    public function findByCategory(string $category): ?VehiculeType
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.category = :category')
            ->setParameter('category', strtoupper($category))
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findByName(string $name): ?VehiculeType
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.name = :name')
            ->setParameter('name', strtolower($name))
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    //    /**
    //     * @return VehiculeType[] Returns an array of VehiculeType objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('v.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?VehiculeType
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
