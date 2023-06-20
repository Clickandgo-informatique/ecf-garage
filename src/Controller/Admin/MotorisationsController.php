<?php

namespace App\Controller\Admin;

use App\Entity\Motorisations;
use App\Form\MotorisationsFormType;
use App\Repository\MotorisationsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/vehicules/motorisations', name: 'app_motorisations_')]
class MotorisationsController extends AbstractController
{
    //Liste des Motorisations de véhicules
    #[Route('/', name: 'liste_motorisations')]
    public function index(MotorisationsRepository $MotorisationsRepository): Response
    {
        $motorisations = $MotorisationsRepository->findBy([], ['nom_motorisation' => 'ASC']);
        return $this->render('admin/motorisations/index.html.twig', compact('motorisations'));
    }

    //Créer une motorisation de véhicules
    #[Route('/creer', name: 'creer_motorisation', methods: ['GET', 'POST'])]
    public function creer(EntityManagerInterface $em, Request $request, SluggerInterface $slugger): Response
    {
        $motorisation = new Motorisations();
        $form = $this->createForm(MotorisationsFormType::class, $motorisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $motorisation->setNomMotorisation($form->get('motorisation')->getData());
            $motorisation->setSlug($slugger->slug($motorisation->getNomMotorisation()));

            $em->persist($motorisation);
            $em->flush();

            $this->addFlash('success', 'La motorisation a bien été enregistrée dans la base');
            return $this->redirectToRoute('app_motorisations_liste_Motorisations');
        }

        return $this->render('admin/Motorisations/Motorisations-form.html.twig', [
            'motorisation' => $form->createView(),
        ]);
    }

    //Modifier une motorisation de véhicule
    #[Route('/modifier/{slug}/{id}', name: 'modifier_motorisation', methods: ['GET', 'POST'])]
    public function modifier(EntityManagerInterface $em, Request $request, $id, $slug, MotorisationsRepository $MotorisationsRepository, SluggerInterface $slugger): Response
    {
        $motorisation = $MotorisationsRepository->find($id);
        $slug = $motorisation->getSlug();
        $motorisation->setSlug($slugger->slug($motorisation->getNomMotorisation()));

        $form = $this->createForm(MotorisationsFormType::class, $motorisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {         

            $em->persist($motorisation);
            $em->flush();

            $this->addFlash('success', 'La motorisation a bien été modifiée dans la base');
            return $this->redirectToRoute('app_motorisations_liste_motorisations');
        }

        return $this->render('admin/Motorisations/Motorisations-form.html.twig', [
            'motorisation' => $form->createView(),
        ]);
    }

    //Supprimer une motorisation de véhicules
    #[Route('/supprimer/{id}', methods: ['GET', 'DELETE'], name: 'supprimer_motorisation')]
    public function supprimer(MotorisationsRepository $MotorisationsRepository, EntityManagerInterface $em, $id)
    {
        $motorisation = $MotorisationsRepository->find($id);
        $em->remove($motorisation);
        $em->flush();

        $this->addFlash('success', 'La motorisation a été supprimée de la base avec succès.');

        return $this->redirectToRoute('app_motorisations_liste_motorisations');
    }
}
