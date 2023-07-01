<?php

namespace App\Controller\Admin;

use App\Entity\Commentaires;
use App\Repository\CommentairesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CommentairesController extends AbstractController
{
    #[Route('/admin/commentaires/liste-commentaires', name: 'app_commentaires_liste_commentaires')]
    public function index(CommentairesRepository $commentairesRepository): Response
    {
        $commentaires = $commentairesRepository->findBy([], ['created_at' => 'desc']);
        return $this->render('commentaires/index.html.twig', compact('commentaires'));
    }


    #[Route('/admin/commentaires/publier-commentaire/{id}', name: 'publier_commentaire')]
    public function publierCommentaire(Commentaires $commentaire, EntityManagerInterface $em, $id): Response
    {
        //Active ou désactive le champ de publication dans la base   
        $commentaire->setPublication(($commentaire->isPublication()) ? false : true);

        $em->persist($commentaire);
        $em->flush();

        if (!$commentaire->isPublication()) {
            $this->addFlash('success', 'Le commentaire a été publié.');

            return new Response('true');
        } else {
            $this->addFlash('success', "Le commentaire a été retiré de la publication et ne sera pas affiché.");
            return new Response("false");
        }
    }
    #[Route('/admin/commentaires/supprimer-commentaire/{id}', methods: ['GET', 'DELETE'], name: 'supprimer_commentaire')]
    public function supprimerCommentaire(CommentairesRepository $commentairesRepository, EntityManagerInterface $em, $id): Response
    {
        $commentaire = $commentairesRepository->find($id);

        $em->remove($commentaire);
        $em->flush();

        $this->addFlash('success', 'Le commentaire a été retiré de la base.');

        return $this->redirectToRoute('app_commentaires_liste_commentaires');
    }
}
