<?php

namespace App\Controller;

use App\Entity\Vehicules;
use App\Repository\ListeOptionsVehiculeRepository;
use App\Repository\MarquesRepository;
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

    // #[Route('/', name: 'liste_annonces')]
    // public function index(VehiculesRepository $vehiculesRepository): Response
    // {

    //     $annonces = $vehiculesRepository->findBy(['publication_annonce' => true], ['marque' => 'ASC']);

    //     return $this->render('annonces/index.html.twig', compact('annonces'));
    // }

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
    public function index(CacheInterface $cache, Request $request, VehiculesRepository $vehiculesRepository, TypesVehiculesRepository $typesVehiculesRepository, MarquesRepository $marquesRepository): Response
    {
        //Récupération du total de véhicules dans la base avant filtres
        $totalVehicules = $vehiculesRepository->getTotalVehicules();

        //Définition du nombre d'éléments par page
        $limit = 10;

        //Récupération du numéro de page active
        $page = (int)$request->query->get("page", 1);

        //Récupération des filtres de types de véhicules
        $filtreTypes = $request->get('types');
        //Récupération des filtres de marques de véhicules
        $filtreMarques = $request->get('marques');

        //Récupération des valeurs d'input pour filtres d'intervalle
        $prixMin = $request->get('prixMin');
        $prixMax = $request->get('prixMax');
        $kmMax = $request->get('kmMax');
        $kmMin = $request->get('kmMin');
   
        // $yearMax = $request->get('yearMax');
        // $yearMin = $request->get('yearMin');

        //Récupération du total de véhicules dans la base avec filtres
        $totalVehiculesFiltered = $vehiculesRepository->getTotalVehicules($filtreTypes, $filtreMarques);

        //Récupération de tous les véhicules pour pagination et filtres
        $vehicules = $vehiculesRepository->getVehiculesPaginated($page, $limit, $filtreTypes, $filtreMarques, $prixMin, $prixMax,$kmMin,$kmMax);

        //Recherche de tous les types de véhicules
        $typesVehicules = $typesVehiculesRepository->findBy([], ['nom_type' => 'ASC']);

        //Recherche de toutes les marques de véhicules
        $marquesVehicules = $marquesRepository->findBy([], ['marque' => 'ASC']);

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
                    compact('prixMax', 'prixMin', 'kmMin', 'kmMax', 'vehicules', 'typesVehicules', 'marquesVehicules', 'limit', 'page', 'totalVehiculesFiltered')
                )
            ]);
        }

        $types = $cache->get('types_list', function (ItemInterface $item) use ($typesVehiculesRepository) {
            $item->expiresAfter(3600);

            return $typesVehiculesRepository->findAll();
        });

        return $this->render('admin/vehicules/index.html.twig', compact('prixMax', 'prixMin', 'kmMin', 'kmMax', 'vehicules', 'marquesVehicules', 'typesVehicules', 'totalVehicules', 'page', 'limit', 'totalVehiculesFiltered'));
    }

    #[Route('/details-vehicule/{id}', name: 'details_vehicule')]
    public function details(VehiculesRepository $vehiculesRepository, ListeOptionsVehiculeRepository $listeOptionsVehiculeRepository, $id,): Response
    {
        $vehicule = $vehiculesRepository->findOneById($id);
        //$listeOptions = $listeOptionsVehiculeRepository->findBy(['vehicule' => $vehicule]);

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
        return $this->redirectToRoute('app_vehicules_liste_vehicules');
    }
    #[Route('/favoris/suppression/{id}', name: 'suppression_favori')]
    public function suppressionFavori(Vehicules $vehicule, EntityManagerInterface $em): Response
    {
        $vehicule->removeFavori($this->getUser());
        $em->persist($vehicule);
        $em->flush();
        return $this->redirectToRoute('app_vehicules_liste_vehicules');
    }
}
