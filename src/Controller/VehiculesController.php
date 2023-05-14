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
}
