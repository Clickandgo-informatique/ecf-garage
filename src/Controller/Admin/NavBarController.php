<?php

namespace App\Controller\Admin;

use App\Repository\EntrepriseRepository;
use App\Repository\HomepageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NavBarController extends AbstractController
{
    #[Route('/admin/navbar/', name: 'navbar')]
    public function index(EntrepriseRepository $entrepriseRepository, HomepageRepository $homepageRepository): Response
    {

        //Récupération des infos de l'entreprise
        $idEntreprise = $entrepriseRepository->getMaxId();
        $entreprise = $entrepriseRepository->findOneBy(['id' => $idEntreprise]);
        $nomEntreprise = $entreprise->getNomEntreprise();

        //Récupération des infos de page d'accueil
        $idHomepage = $homepageRepository->getMaxId();
        $homepage = $homepageRepository->findOneBy(['id' => $idHomepage]);

        return $this->render('_partials/_nav.html.twig', compact('homepage', 'nomEntreprise'));
    }
}
