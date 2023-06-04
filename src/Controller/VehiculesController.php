<?php

namespace App\Controller;

use App\Entity\Photos;
use App\Entity\Vehicules;
use App\Form\VehiculesFormType;
use App\Repository\ListeOptionsVehiculeRepository;
use App\Repository\TypesVehiculesRepository;
use App\Repository\VehiculesRepository;
use App\Service\PicturesService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/vehicules', name: 'app_vehicules_')]
class VehiculesController extends AbstractController
{
    #[Route('/', name: 'liste_vehicules')]
    public function index(Request $request, VehiculesRepository $vehiculesRepository, TypesVehiculesRepository $typesVehiculesRepository): Response
    {
        //Récupération du total de véhicules dans la base avant filtres
        $totalVehicules = $vehiculesRepository->getTotalVehicules();

        //Définition du nombre d'éléments par page
        $limit = 10;

        //Récupération du numéro de page active
        $page = (int)$request->query->get('page', 1);

        //Récupération des filtres
        $filters = $request->get('typesVehicules');        

        //Récupération de tous les véhicules pour pagination et filtres
        $vehicules = $vehiculesRepository->getVehiculesPaginated($page, $limit, $filters);

        //Recherche de tous les types de véhicules
        $typesVehicules = $typesVehiculesRepository->findBy([], ['nom_type' => 'ASC']);

        //Vérification de si il s'agît d'une requête Ajax
        if ($request->get('ajax')) {
            return "ok";
        }

        return $this->render('vehicules/index.html.twig', compact('vehicules', 'typesVehicules', 'totalVehicules', 'page', 'limit'));
    }

    #[Route('/details-vehicule/{id}', name: 'details_vehicule')]
    public function details(VehiculesRepository $vehiculesRepository, ListeOptionsVehiculeRepository $listeOptionsVehiculeRepository, $id): Response
    {
        $vehicule = $vehiculesRepository->findOneById($id);
        //$listeOptions = $listeOptionsVehiculeRepository->findBy(['vehicule' => $vehicule]);

        return $this->render('./vehicules/details.html.twig', [
            'vehicule' => $vehicule
        ]);
    }

    #[Route('/publier_annonce/{id}', name: 'publier_annonce')]
    public function publierAnnonceVehicule(VehiculesRepository $vehiculesRepository, EntityManagerInterface $em, $id): Response
    {

        $vehicule = $vehiculesRepository->findOneById($id);
        $vehicule->setPublicationAnnonce(true);

        $em->persist($vehicule);
        $em->flush();

        $this->addFlash('success', 'Une annonce concernant ce véhicule a été publiée.');

        return new Response('Annonce publiée avec succès');
    }
    #[Route('/retirer_annonce/{id}', name: 'retirer_annonce')]
    public function retirerAnnonceVehicule(VehiculesRepository $vehiculesRepository, EntityManagerInterface $em, $id): Response
    {

        $vehicule = $vehiculesRepository->findOneById($id);
        $vehicule->setPublicationAnnonce(false);

        $em->persist($vehicule);
        $em->flush();

        $this->addFlash('success', 'L\'annonce concernant ce véhicule a été retirée avec succès.');

        return new Response('Annonce véhicule retirée avec succès');
    }

    //Creer un véhicule
    #[Route('/creer-vehicule', name: 'creer_vehicule')]
    public function creer(Request $request, EntityManagerInterface $em, SluggerInterface $slugger, PicturesService $picturesService): Response
    {
        // $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $vehicule = new Vehicules();
        $form = $this->createForm(VehiculesFormType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isvalid()) {

            //Récupération des photos

            $photos = $form->get('photos')->getData();

            foreach ($photos as $photo) {
                //Dossier de destination
                $folder = 'vehicules';
                //Appel au service d'ajout d'images
                $fichier = $picturesService->add($photo, $folder, 300, 300);

                $photo = new Photos();

                $photo->setNom($fichier);
                $vehicule->addPhoto($photo);

                $em->persist($photo);
            }

            //Création du slug
            $slug = $slugger->slug($vehicule->getMarque() . ' ' . $vehicule->getModele());
            $vehicule->setSlug($slug);

            $em->persist($vehicule);
            $em->flush();

            $this->addFlash('success', 'Le nouveau véhicule a été enregistré dans la base avec succès.');
            return $this->redirectToRoute('app_vehicules_liste_vehicules');
        }

        return $this->render('vehicules/formVehicule.html.twig', [
            'form' => $form->createView(),
            'titre' => 'Créer nouvelle fiche véhicule'
        ]);
    }

    #[Route('/modifier-vehicule/{id}', name: 'modifier_vehicule')]
    public function modifier($id, vehiculesRepository $vehiculesRepository, Request $request, EntityManagerInterface $em, PicturesService $picturesService): Response
    {
        // $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $vehicule = $vehiculesRepository->find($id);


        $form = $this->createForm(VehiculesFormType::class, $vehicule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isvalid()) {

            //Récupération des photos

            $photos = $form->get('photos')->getData();

            foreach ($photos as $photo) {
                //Dossier de destination
                $folder = 'vehicules';
                //Appel au service d'ajout d'images
                $fichier = $picturesService->add($photo, $folder, 300, 300);

                $photo = new Photos();

                $photo->setNom($fichier);
                $vehicule->addPhoto($photo);

                $em->persist($photo);
            }

            $em->persist($vehicule);
            $em->flush();

            $this->addFlash('success', 'Les modification ont été enregistrées dans la base avec succès.');
            return $this->redirectToRoute('app_vehicules_details_vehicule', ['id' => $vehicule->getId()]);
        }


        return $this->render('vehicules/formVehicule.html.twig', [
            'form' => $form->createView(),
            'vehicule' => $vehicule,
            'titre' => 'Modifier la fiche véhicule'
        ]);
    }

    #[Route('/supprimer-photo/{id}', name: 'supprimer_photo', methods: ['DELETE'])]
    public function supprimerPhoto(Photos $photo, Request $request, EntityManagerInterface $em, PicturesService $picturesService): JsonResponse
    {

        //Vérification des droits utilisateur
        // $this->denyAccessUnlessGranted('ROLE_ADMIN',$photo)

        $data = json_decode($request->getContent(), true);

        //Vérification de la validité du token
        if ($this->isCsrfTokenValid('delete' . $photo->getId(), $data['_token'])) {
            $nom = $photo->getNom();

            if ($picturesService->delete($nom, 'vehicules', 300, 300)) {
                //Suppression de la photo si token valide   
                $em->remove($photo);
                $em->flush();

                return new JsonResponse(['success' => true], 200);
            }

            //La suppression a échoué
            return new JsonResponse(['error' => 'Erreur, la suppression a échoué !'], 400);
        }
        return new JsonResponse(['error' => 'Token invalide'], 400);
    }
}
