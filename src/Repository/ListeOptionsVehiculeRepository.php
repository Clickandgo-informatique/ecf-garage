<?php

namespace App\Repository;

use App\Entity\ListeOptionsVehicule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ListeOptionsVehicule>
 *
 * @method ListeOptionsVehicule|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListeOptionsVehicule|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListeOptionsVehicule[]    findAll()
 * @method ListeOptionsVehicule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
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
//     * @return ListeOptionsVehicule[] Returns an array of ListeOptionsVehicule objects
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

//    public function findOneBySomeField($value): ?ListeOptionsVehicule
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
