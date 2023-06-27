<?php

namespace App\Controller\Admin;

use App\Entity\TypesVehicules;
use App\Form\TypesVehiculesFormType;
use App\Repository\TypesVehiculesRepository;
use App\Repository\VehiculesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/vehicules/types-vehicules', name: 'app_vehicules_types_vehicules_')]
class TypesVehiculesController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(TypesVehiculesRepository $typesVehiculesRepo): Response
    {

        $typesvehicules = $typesVehiculesRepo->findBy([], ['nom_type' => 'ASC']);

        return $this->render('admin/vehicules/typesvehicules.html.twig', ['typesvehicules' => $typesvehicules]);
    }

    //Filtre les véhicules par type de véhicule
    // #[Route('/{slug}', name: 'list')]
    // public function list(TypesVehicules $type, VehiculesRepository $vehiculesRepository, Request $request): Response
    // {
    //     //Recherche du numéro de page dans l'URL
    //     $page = $request->query->getInt('page', 1);

    //     $vehicules = $vehiculesRepository->findVehiculesPaginated($page, $type->getSlug(), 3);

    //     return $this->render('admin/vehicules/index.html.twig', compact('type', 'vehicules'));
    // }

    #[Route('/supprimer/{id}', name: 'supprimer')]
    public function supprimer(EntityManagerInterface $em, TypesVehiculesRepository $typesVehiculesRepo, $id): Response
    {

        $type = $typesVehiculesRepo->find($id);
        $em->remove($type);
        $em->flush();

        $this->addFlash('success', 'Le type de véhicule a été retiré de la base avec succès.');

        return $this->redirectToRoute('app_vehicules_types_vehicules_index');
    }

    //Créer un type de véhicule
    #[Route('/creer', name: 'creer', methods: ['GET', 'POST'])]
    public function creer(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {

        $tv = new TypesVehicules();
        $form = $this->createForm(TypesVehiculesFormType::class, $tv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $slug = $slugger->slug($form->get('nom_type')->getData());
        
            $tv->setSlug($slug);

            $em->persist($tv);
            $em->flush();

            $this->addFlash('success', 'Le nouveau type de véhicule a été enregistré dans la base avec succès.');
            return $this->redirectToRoute('app_vehicules_types_vehicules_index');
        }

        return $this->render('admin/vehicules/formTypesVehicules.html.twig', [
            'tv' => $form->createView()
        ]);
    }

    #[Route('/modifier/{id}', name: 'modifier')]
    public function modifier(TypesVehiculesRepository $tvRepo, Request $request, EntityManagerInterface $em, $id): Response
    {

        $tv = $tvRepo->find($id);

        $form = $this->createForm(TypesVehiculesFormType::class, $tv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($tv);
            $em->flush();

            $this->addFlash('success', 'Le type de véhicule a été modifié avec succès dans la base de données.');
            return $this->redirectToRoute('app_vehicules_types_vehicules_index');
        }
        return $this->render('admin/vehicules/formModifierTypesVehicules.html.twig', [
            'tv' => $tv,
            'form' => $form->createView(),
        ]);
    }
}
