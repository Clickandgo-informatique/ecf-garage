<?php

namespace App\Controller;

use App\Entity\Vehicules;
use App\Repository\VehiculesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vehicules/annonces', name: 'app_vehicules_annonces_')]
class AnnoncesController extends AbstractController
{

    #[Route('/', name: 'liste_annonces')]
    public function index(VehiculesRepository $vehiculesRepository): Response
    {

        $annonces = $vehiculesRepository->findBy(['publication_annonce' => true], ['marque' => 'ASC']);

        return $this->render('annonces/index.html.twig', compact('annonces'));
    }

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
            $this->addFlash('success', "L'annonce concernant ce véhicule a été retirée de la base.");
            return new Response("false");
        }
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
