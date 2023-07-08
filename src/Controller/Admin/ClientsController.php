<?php

namespace App\Controller\Admin;

use App\Entity\Clients;
use App\Form\ClientsFormType;
use App\Repository\ClientsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/clients', name: 'app_clients_')]
class ClientsController extends AbstractController
{
    #[Route('/', name: 'liste_clients')]
    public function index(ClientsRepository $ClientsRepository): Response
    {
        $clients = $ClientsRepository->findBy([], ['nom' => 'ASC']);

        return $this->render('admin/clients/index.html.twig', compact('clients'));
    }

    //Fiche du client
    #[Route('/fiche/{id}', name: 'fiche_client')]
    public function fiche(ClientsRepository $ClientsRepository, $id): Response
    {
        $client = $ClientsRepository->findOneById($id);

        return $this->render('admin/clients/fiche.html.twig', compact('client'));
    }

    //Suppression d'un client
    #[Route('/supprimer/{id}', methods: ['GET', 'DELETE'], name: 'supprimer_client')]
    public function supprimer(EntityManagerInterface $em, ClientsRepository $ClientsRepository, $id): Response
    {
        $client = $ClientsRepository->find($id);
        $vehicules = $client->getVehicules();

        //Controle si des véhicules appartiennent à ce client avant d'effacer sa fiche
        if (count($vehicules) > 0) {
            $this->addFlash('warning', "Ce client possède un ou plusieurs véhicules enregistrés dans la base, effacez les véhicules avant d'effacer le client.");
            return $this->redirectToRoute('app_clients_liste_clients');
        } else {

            $em->remove($client);
            $em->flush();

            $this->addFlash('success', 'Le client a été supprimé de la base avec succès.');
            return $this->redirectToRoute('app_clients_liste_clients');
        }
    }

    //Créer un client
    #[Route('/creer', name: 'creer_client')]
    public function creer(EntityManagerInterface $em, Request $request): Response
    {
        $client = new Clients();
        $form = $this->createForm(ClientsFormType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isvalid()) {

            $em->persist($client);
            $em->flush();

            $this->addFlash('success', 'Le client a bien été enregistré dans la base.');
            return $this->redirectToRoute('app_clients_liste_clients');
        }
        return $this->render('admin/clients/client-form.html.twig', [
            'form' => $form->createView(),
            'titre'=>"Créer un nouveau client"
        ]);
    }

    //Modifier un client
    #[Route('/modifier/{id}', name: 'modifier_client')]
    public function modifier(EntityManagerInterface $em, $id, ClientsRepository $ClientsRepository, Request $request): Response
    {
        $client = $ClientsRepository->find($id);
        $form = $this->createForm(ClientsFormType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isvalid()) {

            $em->persist($client);
            $em->flush();

            $this->addFlash('success', 'Les modifications ont bien été enregistrées dans la base.');
            return $this->redirectToRoute('app_clients_liste_clients');
        }
        return $this->render('admin/clients/client-form.html.twig', [
            'form' => $form->createView(),
            'titre'=>'Modifier la fiche client'
        ]);
    }
}
