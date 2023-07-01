<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    //page du profil utilisateur
    #[Route('/profil', name: 'app_utilisateurs_profil')]
    public function profil(UsersRepository $usersRepository): Response
    {

        $user = $usersRepository->find($this->getUser());

        return $this->render('/profil/profil.html.twig', compact('user'));
    }
}
