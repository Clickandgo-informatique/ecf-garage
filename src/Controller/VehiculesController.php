<?php

namespace App\Controller;

use App\Entity\Vehicules;
use App\Form\VehiculesFormType;
use App\Repository\ListeOptionsVehiculeRepository;
use App\Repository\VehiculesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vehicules', name: 'app_vehicules_')]
class VehiculesController extends AbstractController
{
    #[Route('/', name: 'liste_vehicules')]
    public function index(VehiculesRepository $vehiculesRepository): Response
    {

        $vehicules = $vehiculesRepository->findBy([], ['marque' => 'ASC']);

        return $this->render('vehicules/index.html.twig', compact('vehicules'));
    }

    #[Route('/details/{id}', name: 'details_vehicule')]
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
    #[Route('/creer_vehicule', name: 'creer_vehicule')]
    public function creer(Request $request, EntityManagerInterface $em): Response
    {

        $v = new Vehicules();
        $form = $this->createForm(VehiculesFormType::class, $v);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isvalid()) {

            $em->persist($v);
            $em->flush();

            $this->addFlash('success', 'Le nouveau véhicule a été enregistré dans la base avec succès.');
            return $this->redirectToRoute('app_vehicules_liste_vehicules');
        }

        return $this->render('vehicules/formVehicule.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
