<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UsersFormType;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/utilisateurs', name: 'app_users_')]
class UsersController extends AbstractController
{
    #[Route('/', name: 'liste_utilisateurs')]
    public function index(UsersRepository $usersRepository): Response
    {
        $users = $usersRepository->findBy([], ['nom' => 'ASC']);

        return $this->render('utilisateurs/index.html.twig', compact('users'));
    }
    //Fiche de l'utilisateur
    #[Route('/fiche/{id}', name: 'fiche_utilisateur')]
    public function fiche(UsersRepository $usersRepository, $id): Response
    {
        $user = $usersRepository->findOneById($id);

        return $this->render('utilisateurs/fiche.html.twig', compact('user'));
    }
    //Suppression d'un utilisateur
    #[Route('/supprimer/{id}', methods: ['DELETE'], name: 'supprimer_utilisateur')]
    public function supprimer(EntityManagerInterface $em, UsersRepository $usersRepository, $id): Response
    {
        $user = $usersRepository->find($id);
        $em->remove($user);
        $em->flush();

        $this->addFlash('alert', 'L\'utilisateur a été supprimé de la base avec succès.');
        return $this->redirectToRoute('app_users_liste_utilisateurs');
    }

    //Créer un utilisateur
    #[Route('/creer', name: 'creer_utilisateur')]
    public function creer(EntityManagerInterface $em, Request $request): Response
    {
        $user = new Users();
        $form = $this->createForm(UsersFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isvalid()) {
            $user->setNom($form->get('nom')->getData());

            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'L\utilisateur a bien été enregistré dans la base.');
            return $this->redirectToRoute('app_users_liste_utilisateurs');
        }
        return $this->render('utilisateurs/user-form.html.twig', [
            'user' => $form->createView()
        ]);
    }
}