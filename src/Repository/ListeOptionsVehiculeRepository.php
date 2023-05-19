<?php

namespace App\Repository;

use App\Entity\ListeOptionsVehicule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ListeOptionsVehicle>
 *
 * @method ListeOptionsVehicle|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListeOptionsVehicle|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListeOptionsVehicle[]    findAll()
 * @method ListeOptionsVehicle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListeOptionsVehiculeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListeOptionsVehicule::class);
    }

    public function save(ListeOptionsVehicule $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ListeOptionsVehicule $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ListeOptionsVehicle[] Returns an array of ListeOptionsVehicle objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ListeOptionsVehicle
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
