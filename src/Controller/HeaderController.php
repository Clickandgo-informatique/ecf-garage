<?php

namespace App\Controller;

use App\Repository\EntrepriseRepository;
use App\Repository\HomepageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HeaderController extends AbstractController{
 
    public function afficher(EntrepriseRepository $entrepriseRepository, HomepageRepository $homepageRepository): Response
    {
        //Récupération des infos de l'entreprise
        $idEntreprise = $entrepriseRepository->getMaxId();
        $entreprise = $entrepriseRepository->findOneBy(['id' => $idEntreprise]); 

        //Récupération des infos de page d'accueil
        $idHomepage = $homepageRepository->getMaxId();
        $homepage = $homepageRepository->findOneBy(['id' => $idHomepage]);
  

        return $this->render('_partials/_header.html.twig',compact('homepage','entreprise'));
    }
}
