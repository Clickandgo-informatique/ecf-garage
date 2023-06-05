<?php

namespace App\Repository;

use App\Entity\Vehicules;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vehicules>
 *
 * @method Vehicules|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vehicules|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vehicules[]    findAll()
 * @method Vehicules[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehiculesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicules::class);
    }

    public function save(Vehicules $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Vehicules $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    //Pagination liste véhicules
    public function getVehiculesPaginated(int $page, int $limit = 6, $filtreTypes = null, $filtreMarques = null)
    {
        $limit = abs($limit);

        $query = $this->createQueryBuilder('v');

        //On filtre si filtre multicritères actif
        if ($filtreTypes != null) {
            $query->where('v.type_vehicule IN (:types)')
                ->setParameter(':types', array_values($filtreTypes));
        }
        if ($filtreMarques != null) {
            $query->andWhere('v.marque IN(:marques)')
                ->setParameter(':marques', array_values($filtreMarques));
        }

        $query->orderBy('v.marque')
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit);

        return $query->getQuery()->getResult();
    }

    //Total de véhicules dans la base
    public function getTotalVehicules($filtreTypes = null, $filtreMarques = null)
    {
        $query = $this->createQueryBuilder('v')
            ->select('COUNT(v)');

        //On filtre si filtre multicritères actif
        if ($filtreTypes != null) {
            $query->where('v.type_vehicule IN (:types)')
                ->setParameter(':types', array_values($filtreTypes));
        }

        if ($filtreMarques != null) {
            $query->andWhere('v.marque IN(:marques)')
                ->setParameter(':marques', array_values($filtreMarques));
        }
        return $query->getQuery()->getSingleScalarResult();
    }
}
