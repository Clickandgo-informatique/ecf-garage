<?php
namespace App\Controller;

use App\Repository\VehiculesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/annonces',name:'app_annonces_')]
class AnnoncesController extends AbstractController{
    #[Route('/',name:'liste_annonces')]
    public function index(VehiculesRepository $vehiculesRepository):Response{

        $annonces=$vehiculesRepository->findBy([],['marque'=>'ASC']);
        
        return $this->render('annonces/index.html.twig',compact('annonces'));

    }
}