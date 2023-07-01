<?php

namespace App\Controller\Admin;

use App\Entity\Boites;
use App\Form\BoitesFormType;
use App\Repository\BoitesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/vehicules/boites', name: 'app_boites_')]
class BoitesController extends AbstractController
{
    //Liste des Boites de véhicules
    #[Route('/', name: 'liste_boites')]
    public function index(BoitesRepository $BoitesRepository): Response
    {
        $boites = $BoitesRepository->findBy([], ['description_boite' => 'ASC']);
        return $this->render('admin/boites/index.html.twig', compact('boites'));
    }

    //Créer une boite de véhicules
    #[Route('/creer', name: 'creer_boite', methods: ['GET', 'POST'])]
    public function creer(EntityManagerInterface $em, Request $request, SluggerInterface $slugger): Response
    {
        $boite = new Boites();
        $form = $this->createForm(BoitesFormType::class, $boite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $boite->setdescriptionBoite($form->get('description_boite')->getData());
            $boite->setSlug($slugger->slug($boite->getDescriptionBoite()));

            $em->persist($boite);
            $em->flush();

            $this->addFlash('success', 'La boite a bien été enregistrée dans la base');
            return $this->redirectToRoute('app_boites_liste_boites');
        }

        return $this->render('admin/boites/boites-form.html.twig', [
            'boite' => $form->createView(),
        ]);
    }

    //Modifier une boite de véhicule
    #[Route('/modifier/{slug}/{id}', name: 'modifier_boite', methods: ['GET', 'POST'])]
    public function modifier(EntityManagerInterface $em, Request $request, $id, $slug, BoitesRepository $BoitesRepository, SluggerInterface $slugger): Response
    {
        $boite = $BoitesRepository->find($id);
        $slug = $boite->getSlug();
        $boite->setSlug($slugger->slug($boite->getdescriptionBoite()));

        $form = $this->createForm(BoitesFormType::class, $boite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $boite->setdescriptionBoite($form->get('boite')->getData());

            $em->persist($boite);
            $em->flush();

            $this->addFlash('success', 'La boite a bien été modifiée dans la base');
            return $this->redirectToRoute('app_boites_liste_boites');
        }

        return $this->render('admin/boites/boites-form.html.twig', [
            'boite' => $form->createView(),
        ]);
    }

    //Supprimer une boite de véhicules
    #[Route('/supprimer/{id}', methods: ['GET', 'DELETE'], name: 'supprimer_boite')]
    public function supprimer(BoitesRepository $BoitesRepository, EntityManagerInterface $em, $id)
    {
        $boite = $BoitesRepository->find($id);
        $em->remove($boite);
        $em->flush();

        $this->addFlash('success', 'La boite a été supprimée de la base avec succès.');

        return $this->redirectToRoute('app_boites_liste_boites');
    }
}
