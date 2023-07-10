<?php

namespace App\Controller\Admin;

use App\Entity\Homepage;
use App\Form\HomepageFormType;
use App\Repository\HomepageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/admin/homepage/{id}', name: 'fiche_homepage')]
    public function fiche(EntityManagerInterface $em, Request $request, HomepageRepository $homepageRepository): Response
    {

        //Recherche du nombre d'enregistrements pour limiter la sauvegarde à celui existant
        $rowCount = $homepageRepository->count([]);

        if ($rowCount === 0) {
            $homepage = new Homepage;
            $form = $this->createForm(HomepageFormType::class);

            $this->addFlash('success', "Les données de la page d'accueil (homepage) ont bien été prises en compte dans la base.");
        } else {

            //Recherche de l'id de la page d'accueil (homepage) déjà enregistrée
            $idHomepage = $homepageRepository->getMaxId();
            $homepage = $homepageRepository->find($idHomepage);
            $form = $this->createForm(HomepageFormType::class, $homepage);

            $this->addFlash('success', 'Vos modifications ont bien été prises en compte dans la base.');
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $directory = $this->getParameter('images_directory') . '/logo/';

            //Efface les fichiers images qui existeraient déjà
            // $files = scandir($directory);
            // $countFiles = count($files);

            // if ($countFiles > 0) {
            //     foreach ($files as $imgFile) {
            //         if ($imgFile != "." && $imgFile != "..") {
            //             unlink($imgFile);
            //         }
            //     }
            // }

            //Traitement du fichier attachment du logo
            $logoFile = $form['logo']->getData();

            if($logoFile){
            $extension = $logoFile->guessExtension();
            if (!$extension) {
                // l'extension n'est pas reconnue
                $extension = 'bin';
            }
            $logoFilename = md5(uniqid()) . '.' . $extension;

            $logoFile->move($directory,$logoFilename);            

            $homepage->setLogo($logoFilename);
        }

            $em->persist($homepage);
            $em->flush();
        }

        return $this->render('/admin/homepage/formHomepage.html.twig', [
            'form' => $form->createView(),           
        ]);
    }
}
