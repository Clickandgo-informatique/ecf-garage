<?php

namespace App\Controller;

use App\Form\FormContactType;
use App\Repository\EntrepriseRepository;
use App\Repository\ServicesRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('contact/nous-contacter/', name: 'nous_contacter')]
    public function index(Request $request, EntrepriseRepository $entrepriseRepository, ServicesRepository $servicesRepository, MailerInterface $mailer): Response
    {

        $idEntreprise = $entrepriseRepository->getMaxId();
        $entreprise = $entrepriseRepository->findOneBy(['id' => $idEntreprise]);

        $services = $servicesRepository->findBy([], ['nom' => 'ASC']);

        //Recherche des adresses mails de l'entreprise
        $mail1 = $entreprise->getMailprincipal();
        $mail2 = $entreprise->getMailsecondaire();

        $form = $this->createForm(FormContactType::class);
        $contact = $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to($mail1)
                ->subject($contact->get('subject')->getData())
                ->htmlTemplate('emails/contact_standard.html.twig')
                ->context([
                    'personne' => $contact->get('prenom')->getdata() . ' ' . $contact->get('nom')->getData(),
                    'service' => 'Standard',
                    'mailService' => $mail1,
                    'message' => $contact->get('message')->getData(),
                    'telContact' => $contact->get('telContact')->getData()
                ]);

            $mailer->send($email);

            $this->addFlash('success', 'Le mail a bien été envoyé au service demandé, nous vous répondrons dans les meilleurs délais.');
        }

        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
            'entreprise' => $entreprise,
            'services' => $services
        ]);
    }
}
