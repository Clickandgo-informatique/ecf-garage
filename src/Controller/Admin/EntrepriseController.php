<?php

namespace App\Controller\Admin;

use App\Entity\Entreprise;
use App\Form\EntrepriseFormType;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntrepriseController extends AbstractController
{

    #[Route('/admin/fiche-entreprise', name: 'fiche_entreprise')]
    public function fiche(EntityManagerInterface $em, Request $request, EntrepriseRepository $entrepriseRepository): Response
    { 

        //Recherche du nombre d'enregistrements pour limiter la sauvegarde à celui existant
        $rowCount = $entrepriseRepository->count([]);
        
        if ($rowCount === 0) {
            $entreprise = new Entreprise;
            $form = $this->createForm(EntrepriseFormType::class);

            $this->addFlash('success',"Les données de l'entreprise ont bien été prises en compte dans la base.");
        }else{
            
            //Recherche de l'id de l'entreprise déjà enregistrée
            $idEntreprise=$entrepriseRepository->getMaxId();
            $entreprise=$entrepriseRepository->find($idEntreprise);
            $form = $this->createForm(EntrepriseFormType::class,$entreprise);

            $this->addFlash('success','Vos modifications ont bien été prises en compte dans la base.');
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($entreprise);
            $em->flush();
        }

        return $this->render('/admin/entreprise/formEntreprise.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
