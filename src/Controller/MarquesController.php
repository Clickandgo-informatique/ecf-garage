<?php

namespace App\Controller;

use App\Entity\Marques;
use App\Form\MarquesFormType;
use App\Repository\MarquesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/marques', name: 'app_marques_')]
class MarquesController extends AbstractController
{
    //Liste des marques de véhicules
    #[Route('/', name: 'index')]
    public function index(MarquesRepository $marquesRepository): Response
    {
        $marques = $marquesRepository->findBy([], ['marque' => 'ASC']);
        return $this->render('vehicules/marques/index.html.twig', compact('marques'));
    }

    //Créer une marque de véhicules
    #[Route('/creer', name: 'creer_marque', methods: ['GET', 'POST'])]
    public function creer(EntityManagerInterface $em, Request $request, MarquesRepository $marquesRepository): Response
    {
        $marques = $marquesRepository->findBy([], ['marque' => 'ASC']);
        $marque = new Marques();
        $form = $this->createForm(MarquesFormType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $marque->setMarque($form->get('marque')->getData());

            $em->persist($marque);
            $em->flush();
            $this->addFlash('success', 'La marque a bien été enregistrée dans la base');
            return $this->redirectToRoute('app_marques_index');
        }

        return $this->render('vehicules/marques/marquesForm.html.twig', [
            'marquesForm' => $form->createView(),
        ]);
    }

    //Supprimer une marque de véhicules
    #[Route('/supprimer/{id}', methods: ['DELETE'], name: 'supprimer_marque')]
    public function supprimer(MarquesRepository $marquesRepository, EntityManagerInterface $em, $id)
    {
        $marque = $marquesRepository->find($id);
        $em->remove($marque);
        $em->flush();

        $this->addFlash('success', 'La marque a été supprimée de la base avec succès.');

        return new Response('Suppression effectuée avec succès.', 200);
    }
}
