<?php

namespace App\Controller\Admin;

use App\Entity\ListeOptionsVehicule;
use App\Form\ListeOptionsVehiculeFormType;
use App\Repository\ListeOptionsVehiculeRepository;
use App\Repository\VehiculesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/vehicules/liste-options-vehicule', name: 'app_vehicules_liste_options_vehicule_')]
class ListeOptionsVehiculeController extends AbstractController
{
    #[Route('/ajouter-option/{id}', name: 'ajouter_option')]
    public function ajouter(Request $request, EntityManagerInterface $em, $id, VehiculesRepository $vehiculesRepository): Response
    {

        $option = new ListeOptionsVehicule();
        $form = $this->createForm(ListeOptionsVehiculeFormType::class, $option);
        $vehicule = $vehiculesRepository->find($id);
        $option->setVehicule($vehicule)
            ->setOptionVehicule($form->get('option_vehicule')->getData());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($option);
            $em->flush();

            $this->addFlash('success', 'La nouvelle option a bien été enregistrée pour ce véhicule.');

            return $this->redirectToRoute('app_vehicules_details_vehicule', ['id' => $vehicule->getId()]);
        }

        return $this->render('admin/vehicules/liste-options.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/supprimer-option/{id}', name: 'supprimer_option')]
    public function supprimer(ListeOptionsVehiculeRepository $listeOptionsVehiculeRepository, EntityManagerInterface $em, $id): Response
    {

        $option = $listeOptionsVehiculeRepository->find($id);
        
        $vehicule=$option->getVehicule();
        $em->remove($option);
        $em->flush();

        $this->addFlash('message', "L'option a bien été retirée de la base.");
        return $this->redirectToRoute('app_vehicules_details_vehicule', ['id' => $vehicule->getId()]);
    }
}
