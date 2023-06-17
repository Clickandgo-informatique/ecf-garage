<?php

namespace App\Controller\Admin;

use App\Entity\Marques;
use App\Form\MarquesFormType;
use App\Repository\MarquesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/vehicules/marques', name: 'app_marques_')]
class MarquesController extends AbstractController
{
    //Liste des marques de véhicules
    #[Route('/', name: 'liste_marques')]
    public function index(MarquesRepository $marquesRepository): Response
    {
        $marques = $marquesRepository->findBy([], ['marque' => 'ASC']);
        return $this->render('admin/marques/index.html.twig', compact('marques'));
    }

    //Créer une marque de véhicules
    #[Route('/creer', name: 'creer_marque', methods: ['GET', 'POST'])]
    public function creer(EntityManagerInterface $em, Request $request,SluggerInterface $slugger): Response
    {
        $marque = new Marques();
        $form = $this->createForm(MarquesFormType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $marque->setMarque($form->get('marque')->getData());
            $marque->setSlug($slugger->slug($marque->getMarque()));

            $em->persist($marque);
            $em->flush();
            
            $this->addFlash('success', 'La marque a bien été enregistrée dans la base');
            return $this->redirectToRoute('app_marques_liste_marques');
        }

        return $this->render('admin/marques/marques-form.html.twig', [
            'marque' => $form->createView(),
        ]);
    }

    //Modifier une marque de véhicule
    #[Route('/modifier/{slug}/{id}', name: 'modifier_marque', methods: ['GET', 'POST'])]
    public function modifier(EntityManagerInterface $em, Request $request,$id,$slug,MarquesRepository $marquesRepository,SluggerInterface $slugger): Response
    {
        $marque = $marquesRepository->find($id);
        $slug=$marque->getSlug();
        $marque->setSlug($slugger->slug($marque->getMarque()));

        $form = $this->createForm(MarquesFormType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $marque->setMarque($form->get('marque')->getData());

            $em->persist($marque);
            $em->flush();
            
            $this->addFlash('success', 'La marque a bien été modifiée dans la base');
            return $this->redirectToRoute('app_marques_liste_marques');
        }

        return $this->render('admin/marques/marques-form.html.twig', [
            'marque' => $form->createView(),
        ]);
    }

    //Supprimer une marque de véhicules
    #[Route('/supprimer/{id}', methods: ['GET','DELETE'], name: 'supprimer_marque')]
    public function supprimer(MarquesRepository $marquesRepository, EntityManagerInterface $em, $id)
    {
        $marque = $marquesRepository->find($id);
        $em->remove($marque);
        $em->flush();

        $this->addFlash('success', 'La marque a été supprimée de la base avec succès.');

        return $this->redirectToRoute('app_marques_liste_marques');
    }
}
