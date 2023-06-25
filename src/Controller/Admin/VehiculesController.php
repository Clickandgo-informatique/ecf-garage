<?php

namespace App\Controller\Admin;

use App\Entity\Photos;
use App\Entity\Vehicules;
use App\Form\VehiculesFormType;
use App\Repository\VehiculesRepository;
use App\Service\PicturesService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/vehicules',name:'app_vehicules_')]
class VehiculesController extends AbstractController{

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
            $slug = $slugger->slug($vehicule->getMarque() . ' ' . $vehicule->getModele())->lower();
            $vehicule->setSlug($slug);

            $em->persist($vehicule);
            $em->flush();

            $this->addFlash('success', 'Le nouveau véhicule a été enregistré dans la base avec succès.');
            return $this->redirectToRoute('app_vehicules_liste_vehicules');
        }

        return $this->render('admin/vehicules/formVehicule.html.twig', [
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
            return $this->redirectToRoute('app_vehicules_fiche_vehicule', ['id' => $vehicule->getId()]);
        }


        return $this->render('admin/vehicules/formVehicule.html.twig', [
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
    
    #[Route('/supprimer-vehicule/{id}', name: 'supprimer_vehicule')]
    public function supprimer($id, vehiculesRepository $vehiculesRepository, EntityManagerInterface $em): Response
    {
        $vehicule = $vehiculesRepository->find($id);
        $em->remove($vehicule);
        $em->flush();

        $this->addFlash('message', 'Le véhicule et toutes ses annexes ont été retirés de la base.');
        return $this->redirectToRoute('app_vehicules_liste_vehicules');
    }

    #[Route('/liste-vehicules', name: 'liste_vehicules')]
    public function liste(VehiculesRepository $vehiculesRepository): Response
    {

        $vehicules = $vehiculesRepository->findBy([], ['slug' => 'asc']);

        return $this->render('admin/vehicules/liste-vehicules.html.twig', compact('vehicules'));
    }
}
