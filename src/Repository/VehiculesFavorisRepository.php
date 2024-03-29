<?php

namespace App\Repository;

use App\Entity\VehiculesFavoris;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VehiculesFavoris>
 *
 * @method VehiculesFavoris|null find($id, $lockMode = null, $lockVersion = null)
 * @method VehiculesFavoris|null findOneBy(array $criteria, array $orderBy = null)
 * @method VehiculesFavoris[]    findAll()
 * @method VehiculesFavoris[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehiculesFavorisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VehiculesFavoris::class);
    }

    public function save(VehiculesFavoris $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(VehiculesFavoris $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return VehiculesFavoris[] Returns an array of VehiculesFavoris objects
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

//    public function findOneBySomeField($value): ?VehiculesFavoris
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
