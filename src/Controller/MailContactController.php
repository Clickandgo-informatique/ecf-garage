<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Form\ContactFormType;
use App\Repository\EntrepriseRepository;
use App\Repository\ServicesRepository;
use App\Repository\VehiculesRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contact-par-mail', name: 'app_contact_par_mail_')]
class MailContactController extends AbstractController
{
    #[Route('/envoyer-mail/{id}/{slug}', name: 'envoyer_mail')]
    public function envoyerMail($slug, MailerInterface $mailer, Request $request, ServicesRepository $servicesRepository, $id): Response
    {
        //Si l'on se trouve sur la page ou fiche d'un service       
        $service = $servicesRepository->find($id);
        $nomService = $service->getNom();

        //Recherche des adresses mails du service
        $mail1 = $service->getMailService1();
        $placeholder = "Indiquez ici ce qui vous amène à nous contacter sans oublier vos coordonnées complète et les données du véhicule concerné.";
        $slug = $service->getSlug();

        $form = $this->createForm(ContactFormType::class);
        $contact = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to($mail1)
                ->subject($contact->get('subject')->getData())
                ->htmlTemplate('emails/contact_service.html.twig')
                ->context([
                    'service' => $service,
                    'nomService' => $nomService,
                    'mailService' => $mail1,
                    'message' => $contact->get('message')->getData(),
                    'telContact' => $contact->get('telContact')->getData()
                ]);

            $mailer->send($email);

            $this->addFlash('success', 'Le mail a bien été envoyé au service demandé, nous vous répondrons dans les meilleurs délais.');
            return $this->redirectToRoute('app_index', [
                'slug' => $slug
            ]);
        }

        return $this->render('_partials/_modale-contact.html.twig', [
            'mailService' => $mail1,
            'service' => $service,
            'nomService' => $nomService,
            'form' => $form->createView()
        ]);
    }

    // Contact mail pour les annonces de véhicules d'occasion

    #[Route('/envoyer-mail-annonce/{id}', name: 'annonce_vehicule')]
    public function envoyerMailAnnonce(MailerInterface $mailer, Request $request, EntrepriseRepository $entrepriseRepository, VehiculesRepository $vehiculesRepository, $id): Response
    {
        //Si l'on se trouve sur la card d'une annonce de véhicule      
        $vehicule = $vehiculesRepository->find($id);

        //Recherche des adresses mails du service
        $idEntreprise = $entrepriseRepository->getMaxId();
        $entreprise=$entrepriseRepository->find($idEntreprise);
        
        //Recherche du véhicule et de sa référence interne
        $vehicule=$vehiculesRepository->find($id);
        $ref=$vehicule->getReferenceInterne();

        $mailService=$entreprise->getMailAnnoncesOccasions();
        $nomService = " annonces véhicules d'occasion";       
      
        $slug = $vehicule->getSlug();

        $form = $this->createForm(ContactFormType::class);
        $contact = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to($mailService)
                ->subject($contact->get('subject')->getData())
                ->htmlTemplate('emails/contact_service_annonces.html.twig')
                ->context([
                    'ref'=>$ref,
                    'vehicule'=>$vehicule->getMarque() . ' ' . $vehicule->getModele(),                  
                    'service' => $nomService,
                    'mailService' => $mailService,
                    'message' => $contact->get('message')->getData(),
                    'telContact' => $contact->get('telContact')->getData()
                ]);

            $mailer->send($email);

            $this->addFlash('success', 'Le mail a bien été envoyé au service demandé, nous vous répondrons dans les meilleurs délais.');
            return $this->redirectToRoute('app_vehicules_annonces_index', [
                'slug' => $slug
            ]);
        }

        return $this->render('_partials/_modale-contact.html.twig', [
            'ref' => $vehicule->getReferenceInterne(),
            'vehicule' => $vehicule->getMarque() . ' ' . $vehicule->getModele(),
            'mailService' => $mailService,
            'service' => $nomService,
            'nomService' => $nomService,
            'form' => $form->createView()
        ]);
    }
}
