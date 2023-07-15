<?php

namespace App\Controller;

use App\Entity\Vehicules;
use App\Repository\BoitesRepository;
use App\Repository\ListeOptionsVehiculeRepository;
use App\Repository\MarquesRepository;
use App\Repository\MotorisationsRepository;
use App\Repository\TypesVehiculesRepository;
use App\Repository\VehiculesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

#[Route('/vehicules/annonces', name: 'app_vehicules_annonces_')]
class AnnoncesController extends AbstractController
{
    #[Route('/publier-annonce/{id}', name: 'publier_annonce')]
    public function publierAnnonceVehicule(Vehicules $vehicule, EntityManagerInterface $em, $id): Response
    {
        //Active ou désactive le champ de publication dans la base   
        $vehicule->setPublicationAnnonce(($vehicule->isPublicationAnnonce()) ? false : true);

        $em->persist($vehicule);
        $em->flush();

        if (!$vehicule->isPublicationAnnonce()) {
            $this->addFlash('success', 'Une annonce concernant ce véhicule a été publiée.');

            return new Response('true');
        } else {
            $this->addFlash('success', "L'annonce concernant ce véhicule a été retirée de la base avec succès.");
            return new Response("false");
        }
    }

    #[Route('/', name: 'index')]
    public function index(CacheInterface $cache, Request $request, VehiculesRepository $vehiculesRepository, TypesVehiculesRepository $typesVehiculesRepository, MarquesRepository $marquesRepository, MotorisationsRepository $motorisationsRepository, BoitesRepository $boitesRepository): Response
    {

        //Récupération du total de véhicules dans la base avant filtres
        $totalVehiculesFiltered = $vehiculesRepository->getTotalVehicules();

        //Définition du nombre d'éléments par page
        $limit = 9;

        //Récupération du numéro de page active
        $page = (int)$request->query->get("page", 1);

        //Récupération des favoris de l'utilisateur actif
        $user = $this->getUser();

        //Récupération des filtres de types de véhicules
        $filtreTypes = $request->get('typesVehicules');
        //Récupération des filtres de marques de véhicules
        $filtreMarques = $request->get('marques');
        //Récupération valeur classerPar
        $classerPar = $request->get('classerPar');
        //Récupération valeurs motorisations
        $filtreMotorisations = $request->get('typesMotorisations');
        //Récupération des types de boîtes de vitesse
        $filtreBoites = $request->get('boites');

        //Récupération des valeurs d'input pour filtres d'intervalle
        $prixMin = $request->get('prixMin');
        $prixMax = $request->get('prixMax');
        $kmMax = $request->get('kmMax');
        $kmMin = $request->get('kmMin');
        $yearMin = $request->get('yearMin');
        $yearMax = $request->get('yearMax');    
        

        //Récupération de tous les véhicules pour pagination et filtres
        $paginationResult = $vehiculesRepository->getVehiculesPaginated($page, $limit, $filtreTypes, $filtreMarques, $prixMin, $prixMax, $kmMin, $kmMax, $classerPar, $filtreMotorisations, $filtreBoites, $yearMin,$yearMax, $user);

        $vehicules = $paginationResult->getItems();
        $totalItems = $paginationResult->getTotalItems();

        //Recherche de tous les types de véhicules
        $typesVehicules = $typesVehiculesRepository->findBy([], ['nom_type' => 'ASC']);

        //Recherche de tous les types de motorisations
        $typesMotorisations = $motorisationsRepository->findBy([], ['nom_motorisation' => 'ASC']);

        //Recherche de toutes les marques de véhicules
        $marquesVehicules = $marquesRepository->findBy([], ['marque' => 'ASC']);

        //Recherche de tous les types de boîtes de vitesse
        $typesBoites = $boitesRepository->findBy([], ['description_boite' => 'ASC']);

        //Infos minimum et maximum pour les sliders de filtre dans la base
        // $prixMax = $vehiculesRepository->getPrixMax();
        // $prixMin = $vehiculesRepository->getPrixMin();
        // $kmMin = $vehiculesRepository->getKmMin();
        // $kmMax = $vehiculesRepository->getKmMax();

        //Vérification de si il s'agît d'une requête Ajax
        if ($request->get('ajax')) {

            //Renvoi d'une réponse en JSON
            return new JsonResponse([
                'content' => $this->renderView(
                    'admin/vehicules/_content.html.twig',
                    compact('user', 'classerPar', 'prixMax', 'prixMin', 'kmMin', 'kmMax', 'vehicules', 'typesVehicules', 'marquesVehicules', 'limit', 'page', 'typesMotorisations', 'typesBoites', 'yearMin','yearMax', 'totalItems')
                )
            ]);
        }
        //Gestion du cache navigateur
        $typesVehicules = $cache->get('types_list', function (ItemInterface $item) use ($typesVehiculesRepository) {
            $item->expiresAfter(3600);

            return $typesVehiculesRepository->findAll();
        });
        $typesMotorisations = $cache->get('types_motorisations_list', function (ItemInterface $item) use ($motorisationsRepository) {
            $item->expiresAfter(3600);

            return $motorisationsRepository->findAll();
        });

        return $this->render('admin/vehicules/index.html.twig', compact('user', 'classerPar', 'prixMax', 'prixMin', 'kmMin', 'kmMax', 'vehicules', 'marquesVehicules', 'typesVehicules', 'page', 'limit', 'typesMotorisations', 'typesBoites', 'yearMin','yearMax', 'totalItems'));
    }

    #[Route('/details-vehicule/{id}', name: 'details_vehicule')]
    public function details(VehiculesRepository $vehiculesRepository, ListeOptionsVehiculeRepository $listeOptionsVehiculeRepository, $id,): Response
    {
        $vehicule = $vehiculesRepository->findOneById($id);

        return $this->render('admin/vehicules/details.html.twig', [
            'vehicule' => $vehicule,
        ]);
    }

    #[Route('/favoris/ajout/{id}', name: 'ajout_favori')]
    public function ajoutFavori(Vehicules $vehicule, EntityManagerInterface $em): Response
    {
        $vehicule->addFavori($this->getUser());
        $em->persist($vehicule);
        $em->flush();
        return $this->redirectToRoute('app_vehicules_annonces_index');
    }
    #[Route('/favoris/suppression/{id}', name: 'suppression_favori')]
    public function suppressionFavori(Vehicules $vehicule, EntityManagerInterface $em): Response
    {
        $vehicule->removeFavori($this->getUser());
        $em->persist($vehicule);
        $em->flush();
        return $this->redirectToRoute('app_vehicules_annonces_index');
    }
}
