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

#[Route('/admin/contact-par-mail', name: 'app_contact_par_mail_')]
class MailContactController extends AbstractController
{
    #[Route('/envoyer-mail/{id}/', name: 'envoyer_mail')]
    public function envoyerMail(MailerInterface $mailer,Request $request, ServicesRepository $servicesRepository,$id): Response
    {
        //Si l'on se trouve sur la page ou fiche d'un service
        $service_a_contacter = $servicesRepository->find($id);
 
        //Recherche des adresses mails du service
        $mail1 = $service_a_contacter->getMailService1(); 

        $form = $this->createForm(ContactFormType::class);
        $contact=$form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $email=(new TemplatedEmail())
            ->from($contact->get('email')->getData())
            ->to($mail1)
            ->subject($contact->get('title')->getData())
            ->htmlTemplate('emails/contact_service.html.twig')
            ->context([
                'service'=>$service_a_contacter,
                'mail'=>$mail1,
                'message'=>$contact->get('message')->getData()
            ]);

            $this->addFlash('message', 'Le mail a bien été envoyé au service demandé, nous vous répondrons dans les meilleurs délais.');
        }

        return $this->render('_modale-contact.html.twig', [
            'mail1' => $mail1,                        
            'service' => $service_a_contacter,
            'form' => $form->createView()
        ]);
    }
}
