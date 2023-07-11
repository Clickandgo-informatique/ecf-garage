<?php

namespace App\Controller;

use App\Entity\Commentaires;
use App\Form\CommentairesType;
use App\Repository\CommentairesRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\HomepageRepository;
use App\Repository\ServicesRepository;
use App\Repository\VehiculesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(
        Request $request,
        EntityManagerInterface $em,
        CommentairesRepository $commentairesRepository,
        ServicesRepository $servicesRepository,
        VehiculesRepository $vehiculesRepository,
        HomepageRepository $homepageRepository,
        EntrepriseRepository $entrepriseRepository
    ): Response {
        //Liste de tous les services
        $services = $servicesRepository->findBy([], ['nom' => 'ASC']);
        //Liste de tous les commentaires
        $commentaires = $commentairesRepository->findBy(['publication' => true], ['created_at' => 'DESC']);

        //Récupération des 5 dernières annonces de véhicules
        $vehicules = $vehiculesRepository->getLastFiveVehicules();

        //Récupération des infos de page d'accueil
        $idHomepage = $homepageRepository->getMaxId();
        $homepage = $homepageRepository->findOneBy(['id' => $idHomepage]);

        //Récupération des données de l'entreprise
        $idEntreprise=$entrepriseRepository->getMaxId();
        $entreprise=$entrepriseRepository->findOneBy(['id'=>$idEntreprise]);
        $nomEntreprise=$entreprise->getNomEntreprise();

        //Génération du formulaire de commentaires
        $commentaire = new Commentaires;
        $commentForm = $this->createForm(CommentairesType::class, $commentaire);
        $commentForm->handleRequest(($request));

        //Traitement du formulaire
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {

            $commentaire->setCreatedAt(new \DateTimeImmutable());
            //Récupération du contenu du champ parentid
            $parentid = $commentForm->get('parentid')->getData();

            //Recherche du commentaire parent
            if ($parentid != null) {
                $parent = $commentairesRepository->find($parentid);
            }

            $commentaire->setParent($parent ?? null);
            $em->persist($commentaire);
            $em->flush();

            $this->addFlash('success', 'Votre commentaire a bien été envoyé, il sera publié suite à modération dans les plus brefs délais !');
            return $this->redirectToRoute('app_index');
        }
        return $this->render('main/index.html.twig', [
            'commentaires' => $commentaires,
            'services' => $services,
            'vehicules' => $vehicules,
            'homepage' => $homepage,
            'nomEntreprise'=>$nomEntreprise,
            'commentForm' => $commentForm->createView(),

        ]);
    }
}
