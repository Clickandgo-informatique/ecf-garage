<?php

namespace App\Controller;

use App\Repository\VehiculesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vehicules', name: 'app_vehicules_')]
class VehiculesController extends AbstractController
{
    #[Route('/', name: 'liste_vehicules')]
    public function index(VehiculesRepository $vehiculesRepository): Response
    {

        $vehicules = $vehiculesRepository->findBy([], ['marque' => 'ASC']);

        return $this->render('vehicules/index.html.twig', compact('vehicules'));
    }

    #[Route('/details/{id}', name: 'details_vehicule')]
    public function details(VehiculesRepository $vehiculesRepository, $id): Response
    {
        $vehicule = $vehiculesRepository->findOneById($id);
       
        return $this->render('./vehicules/details.html.twig', [
            'vehicule' => $vehicule
        ]);
    }

}
