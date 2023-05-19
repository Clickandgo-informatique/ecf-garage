<?php
namespace App\Controller;

use App\Repository\VehiculesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vehicules/annonces',name:'app_vehicules_annonces_')]
class AnnoncesController extends AbstractController{
    #[Route('/',name:'liste_annonces')]
    public function index(VehiculesRepository $vehiculesRepository):Response{

        $annonces=$vehiculesRepository->findBy(['publication_annonce'=>true],['marque'=>'ASC']);
        
        return $this->render('annonces/index.html.twig',compact('annonces'));

    }
}