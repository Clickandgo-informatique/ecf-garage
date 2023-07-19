<?php

namespace App\Controller\Admin;

use App\Entity\Commentaires;
use App\Form\CommentairesType;
use App\Repository\CommentairesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CommentairesController extends AbstractController
{
    //Administration : Liste des commentaires
    #[Route('/admin/commentaires/liste-commentaires', name: 'app_commentaires_liste_commentaires')]
    public function index(CommentairesRepository $commentairesRepository, Request $request): Response
    {
        $page = (int)$request->query->get('page', 1);
        $limit = 10;
        $paginationResult = $commentairesRepository->getListeCommentairesPaginated($limit, $page);
        $commentaires = $paginationResult->getItems();
        $totalItems = $paginationResult->getTotalItems();

        return $this->render('commentaires/index.html.twig', compact('commentaires', 'limit', 'page', 'totalItems'));
    }

    //Créer un commentaire client
    #[Route('/admin/commentaires/creer-commentaire', name: 'creer_commentaire')]
    public function creer(Request $request, EntityManagerInterface $em, CommentairesRepository $commentairesRepository): Response
    {
        $form = $this->createForm(CommentairesType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentaire = new Commentaires();

            $commentaire->setCreatedAt(new \DateTimeImmutable());
            //Récupération du contenu du champ parentid
            $parentid = $form->get('parentid')->getData();

            //Recherche du commentaire parent
            if ($parentid != null) {
                $parent = $commentairesRepository->find($parentid);
            }

            $commentaire->setParent($parent ?? null);

            $em->persist($commentaire);
            $em->flush();

            $this->addFlash('success', 'Le commentaire a été enregistré dans la base avec succès, il est en attente de publication.');
            return $this->redirectToRoute('app_commentaires_liste_commentaires');
        }

        return $this->render('commentaires/creer-commentaire.html.twig', [
            'form' => $form->createView()
        ]);
    }

    //Publication d'un commentaire
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
