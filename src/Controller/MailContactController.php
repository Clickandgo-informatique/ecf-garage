<?php

namespace App\Controller;

use App\Form\ContactFormType;
use App\Repository\ServicesRepository;
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
        $service_a_contacter = $servicesRepository->find($id);
        $nomService = $service_a_contacter->getNom();

        //Recherche des adresses mails du service
        $mail1 = $service_a_contacter->getMailService1();
        $placeholder = "Indiquez ici ce qui vous amène à nous contacter sans oublier vos coordonnées complète et les données du véhicule concerné.";
        $slug = $service_a_contacter->getSlug();

        $form = $this->createForm(ContactFormType::class);
        $contact = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to($mail1)
                ->subject($contact->get('subject')->getData())
                ->htmlTemplate('emails/contact_service.html.twig')
                ->context([
                    'service' => $nomService,
                    'mail' => $mail1,
                    'message' => $contact->get('message')->getData()                    
                ]);
            $mailer->send($email);

            $this->addFlash('success', 'Le mail a bien été envoyé au service demandé, nous vous répondrons dans les meilleurs délais.');
            return $this->redirectToRoute('app_index', [
                'slug' => $slug
            ]);
        }

        return $this->render('_partials/_modale-contact.html.twig', [
            'mail1' => $mail1,
            'service' => $service_a_contacter,           
            'form' => $form->createView()
        ]);
    }
}
