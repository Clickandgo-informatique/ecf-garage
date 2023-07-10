<?php

namespace App\Repository;

use App\Entity\OptionsVehicules;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OptionsVehicules>
 *
 * @method OptionsVehicules|null find($id, $lockMode = null, $lockVersion = null)
 * @method OptionsVehicules|null findOneBy(array $criteria, array $orderBy = null)
 * @method OptionsVehicules[]    findAll()
 * @method OptionsVehicules[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OptionsVehiculesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OptionsVehicules::class);
    }

    public function save(OptionsVehicules $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(OptionsVehicules $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return OptionsVehicules[] Returns an array of OptionsVehicules objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?OptionsVehicules
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
