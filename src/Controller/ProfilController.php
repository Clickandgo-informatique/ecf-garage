<?php

namespace App\Controller;

use App\Form\UserProfileFormType;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    //Modifier le profil
    #[Route('/profil/modifier-profil', name: 'modifier_profil')]
    public function edit(UsersRepository $usersRepository, Request $request, EntityManagerInterface $em):Response{

        $user=$usersRepository->find($this->getUser());
        $form=$this->createForm(UserProfileFormType::class,$user);
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){
            $em->persist($user);
            $em->flush();

            $this->addFlash('success','Vos modifications ont bien été prises en compte dans la base de données.');

        }

        return $this->render('admin/utilisateurs/edit_profile.html.twig',compact('form'));

    }

}
