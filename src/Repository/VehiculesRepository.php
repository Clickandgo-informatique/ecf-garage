<?php

namespace App\Repository;

use App\Entity\Vehicules;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    //Pagination liste véhicules après filtre
    public function getVehiculesPaginated(int $page, int $limit = 100, $filtreTypes = null, $filtreMarques = null, int $prixMin = null, int $prixMax = null)
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

        //Filtre sur intervalle de prix
        if ($prixMin != null && $prixMax != null) {
            $query->andWhere('v.prix_vente >= :prixMin and v.prix_vente <= :prixMax')
                ->setParameter(':prixMin', $prixMin)
                ->setParameter(':prixMax', $prixMax);
        }

        dd($prixMax);

        $query->orderBy('v.marque')
            ->orderBy('v.prix_vente')
            ->setFirstResult(($page * $limit) - $limit)
            ->setMaxResults($limit);

        return $query->getQuery()->getResult();
    }

    //Max prix de vente pour filtre d'intervalle
    public function getPrixMax()
    {
        $query = $this->createQueryBuilder('pm')
            ->select('MAX(pm.prix_vente)');
        return $query->getQuery()->getSingleScalarResult();
    }
    //Min prix de vente pour filtre d'intervalle
    public function getPrixMin()
    {
        $query = $this->createQueryBuilder('pm')
            ->select('MIN(pm.prix_vente)');
        return $query->getQuery()->getSingleScalarResult();
    }
    //Min kilométrage pour filtre d'intervalle
    public function getKmMin()
    {
        $query = $this->createQueryBuilder('kmm')
            ->select('MIN(kmm.kilometrage)');
        return $query->getQuery()->getSingleScalarResult();
    }
    //Max kilométrage pour filtre d'intervalle
    public function getKmMax()
    {
        $query = $this->createQueryBuilder('kmm')
            ->select('MAX(kmm.kilometrage)');
        return $query->getQuery()->getSingleScalarResult();
    }

    //Total de véhicules dans la base
    public function getTotalVehicules($filtreTypes = null, $filtreMarques = null, $prixMin = 0, $prixMax = 500000)
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
