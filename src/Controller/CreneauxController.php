<?php

namespace App\Controller;

use App\Entity\Creneaux;
use App\Form\CreneauxFormType;
use App\Repository\CreneauxRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/horaires-semaine', name: 'app_horaires_semaine_')]
class CreneauxController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CreneauxRepository $creneauxRepository): Response
    {
        $creneauxLundi = $creneauxRepository->findBy(['jour' => 'Lundi'], ['debut' => 'ASC']);
        $creneauxMardi = $creneauxRepository->findBy(['jour' => 'Mardi'], ['debut' => 'ASC']);
        $creneauxMercredi = $creneauxRepository->findBy(['jour' => 'Mercredi'], ['debut' => 'ASC']);
        $creneauxJeudi = $creneauxRepository->findBy(['jour' => 'Jeudi'], ['debut' => 'ASC']);
        $creneauxVendredi = $creneauxRepository->findBy(['jour' => 'Vendredi'], ['debut' => 'ASC']);
        $creneauxSamedi = $creneauxRepository->findBy(['jour' => 'Samedi'], ['debut' => 'ASC']);
        $creneauxDimanche = $creneauxRepository->findBy(['jour' => 'Dimanche'], ['debut' => 'ASC']);

        return $this->render('creneaux/index.html.twig', compact('creneauxLundi', 'creneauxMardi', 'creneauxMercredi', 'creneauxJeudi', 'creneauxVendredi', 'creneauxSamedi', 'creneauxDimanche'));
    }

    //Créer un créneau
    #[Route('/creer-creneau', name: 'creer_creneau')]
    public function creer(EntityManagerInterface $em, Request $request, CreneauxRepository $creneauxRepository): Response
    {
        $creneau = new Creneaux();

        $form = $this->createForm(CreneauxFormType::class, $creneau, ['attr' => ['id' => 'creneauxForm']]);
        $form->handleRequest($request);
        $titre = "Créer un créneau horaire";

        if ($form->isSubmitted() && $form->isvalid()) {

            //Fonction vérifiant qu'un nouveau créneau ne chevauche pas les créneaux existants pour un jour donné
            $jour = $form->get('jour')->getData();
            $debut = $form->get('debut')->getData();
            $fin = $form->get('fin')->getData();

            $query = $creneauxRepository->verifierCreneau($jour, $debut, $fin);

            if (count($query) == 0) {
                $em->persist($creneau);
                $em->flush();

                $this->addFlash('success', 'Le nouveau créneau a été créé avec succès dans la base.');
                return $this->redirectToRoute('app_horaires_semaine_index');
            } else {
                return new response("Il n'est pas possible de créer un nouveau créneau car celui-ci chevaucherait un créneau déjà existant...");
            }
        }

        return $this->render('creneaux/creneauxForm.html.twig', [

            'creneauxForm' => $form->createView(),
            'titre' => $titre
        ]);
    }
    //Modifier un créneau
    #[Route('/modifier-creneau/{id}', name: 'modifier_creneau')]
    public function modifier(CreneauxRepository $creneauxRepository, $id, EntityManagerInterface $em, Request $request): Response
    {
        $creneau = $creneauxRepository->find($id);

        $form = $this->createForm(CreneauxFormType::class, $creneau);
        $form->handleRequest($request);
        $titre = "Modifier un créneau horaire";


        if ($form->isSubmitted() && $form->isvalid()) {

            $em->persist($creneau);
            $em->flush();

            $this->addFlash('success', 'Le créneau a été modifié avec succès dans la base.');
            return $this->redirectToRoute('app_horaires_semaine_index');
        }

        return $this->render('creneaux/creneauxForm.html.twig', [

            'creneauxForm' => $form->createView(),
            'titre' => $titre
        ]);
    }
    //Supprimer un créneau
    #[Route('/supprimer-creneau/{id}', name: 'supprimer_creneau')]
    public function supprimer(CreneauxRepository $creneauxRepository, $id, EntityManagerInterface $em): Response
    {
        $creneau = $creneauxRepository->find($id);

        $em->remove($creneau);
        $em->flush();

        $this->addFlash('success', 'Le créneau a été supprimé avec succès dans la base.');
        return $this->redirectToRoute('app_horaires_semaine_index');
    }

    //Afficher le créneau du jour actif sur sections footer (embedding)
    public function afficherCreneauJourActif(CreneauxRepository $creneauxRepository): Response
    {       
        $creneauxActifsJour = $creneauxRepository->getCreneauxActifsJour();
        $prochainsCreneaux = $creneauxRepository->getProchainsCreneaux();

        return $this->render(
            '_partials/_creneauxJour.html.twig',
            compact('creneauxActifsJour', 'prochainsCreneaux')
        );
    }
}
