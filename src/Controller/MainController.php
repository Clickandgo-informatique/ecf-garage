<?php

namespace App\Controller;

use App\Entity\Commentaires;
use App\Form\CommentairesType;
use App\Repository\CommentairesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(Request $request, EntityManagerInterface $em, CommentairesRepository $commentairesRepository): Response
    {
        //Liste de tous les commentaires
        $commentaires = $commentairesRepository->findBy([], ['created_at' => 'DESC']);
        //Gestion des Commentaires
        $commentaire = new Commentaires();


        //Génération du formulaire de commentaires
        $commentForm = $this->createForm(CommentairesType::class, $commentaire);

        $commentForm->handleRequest(($request));

        //Traitement du formulaire
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {

            //Récupération du contenu du champ parentid
            $parentid = $commentForm->get('parentid')->getData();

            //Recherche du commentaire parent
            if ($parentid != null) {
                $parent = $commentairesRepository->find($parentid);
            }

            $commentaire->setParent($parent ?? null);

            $em->persist($commentaire);
            $em->flush();

            $this->addFlash('message', 'Votre commentaire a bien été envoyé, il sera publié suite à modération dans les plus brefs délais !');
            return $this->redirectToRoute('app_index');
        }
        return $this->render('main/index.html.twig', [
            'commentaires' => $commentaires,
            'commentForm' => $commentForm->createView()
        ]);
    }
}
