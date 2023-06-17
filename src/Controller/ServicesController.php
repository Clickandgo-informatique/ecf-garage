<?php

namespace App\Controller;

use App\Entity\Services;
use App\Form\ServicesFormType;
use App\Repository\ServicesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/services', name: 'app_services_')]
class ServicesController extends AbstractController
{
    public function __construct(private SluggerInterface $slugger)
    {
    }

    #[Route('/', name: 'index')]
    public function index(ServicesRepository $servicesRepository): Response
    {
        $services = $servicesRepository->findBy([], ['nom' => 'ASC']);

        return $this->render('services/index.html.twig', [
            'services' => $services
        ]);
    }
    #[Route('/liste-services', name: 'liste_services')]
    public function liste(ServicesRepository $servicesRepository): Response
    {
        $services = $servicesRepository->findBy([], ['nom' => 'ASC']);

        return $this->render('services/liste-services.html.twig', [
            'services' => $services
        ]);
    }

    //Créer un service
    #[Route('/creer-service', name: 'creer_service')]
    public function creer(EntityManagerInterface $em, Request $request): Response
    {

        $service = new Services;

        $form = $this->createForm(ServicesFormType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $service->setSlug($this->slugger->slug($form->get('nom')->getdata())->lower());
            $em->persist($service);
            $em->flush();

            $this->addFlash('message', 'Le nouveau service a bien été enregistré dans la base.');
            return $this->redirectToRoute('app_services_index');
        }

        return $this->render('services/servicesForm.html.twig', [
            'servicesForm' => $form->createView(),
            'titre' => 'Créer un nouveau service'
        ]);
    }

    #[Route('/modifier-service/{slug}/{id}', name: 'modifier_service')]
    public function modifier(Request $request, ServicesRepository $servicesRepository, $id, $slug, EntityManagerInterface $em): Response
    {
        $service = $servicesRepository->find($id);
        $slug = $service->getSlug();

        $form = $this->createForm(ServicesFormType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $service->setSlug($this->slugger->slug($form->get('nom')->getdata())->lower());
            $em->persist($service);
            $em->flush();

            $this->addFlash('message', 'Le nouveau service a bien été modifié dans la base.');
            return $this->redirectToRoute('app_services_liste_services');
        }

        return $this->render('services/servicesForm.html.twig', [
            'servicesForm' => $form->createView(),
            'titre' => 'Modifier un service'
        ]);
    }
    #[Route('/supprimer-service/{slug}/{id}', name: 'supprimer_service')]
    public function supprimer(ServicesRepository $servicesRepository, $id, $slug, EntityManagerInterface $em): Response
    {
        $service = $servicesRepository->find($id);
        $slug = $service->getSlug();
        $em->remove($service);
        $em->flush();
        $this->addFlash('message', 'Le service ' . $slug . ' a bien été supprimé de la base.');
        return $this->redirectToRoute('app_services_liste_services');
    }
    #[Route('/fiche-service/{slug}/{id}', name: 'fiche_service')]
    public function fiche(ServicesRepository $servicesRepository, $id, $slug): Response
    {
        $service = $servicesRepository->find($id);
        $slug = $service->getSlug();

        return $this->render('services/fiche.html.twig', [
            'service' => $service
        ]);
    }
}
