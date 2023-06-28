<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use App\Repository\UsersRepository;
use App\Security\UsersAuthenticator;
use App\Service\JWTService;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UsersAuthenticator $authenticator, EntityManagerInterface $entityManager, SendMailService $mail, JWTService $jwt): Response
    {
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            //Génération du JWT de l'utilisateur

            //Création du header
            $header = [
                'typ' => 'JWT',
                'alg' => 'HS256'
            ];

            //Création du payload
            $payload = ['user_id' => $user->getId()];

            //Génération du token
            $token = $jwt->generate(
                $header,
                $payload,
                $this->getParameter(('app.jwtsecret'))
            );

            //On envoie le mail
            $mail->send(
                "no-reply@garage-parrot.fr",
                $user->getEmail(),
                'Activation de votre compte sur le site du garage Parrot',
                'register',
                compact('user', 'token')
            );

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verif/{token}', name: 'verify_user')]
    public function verifyUser($token, JWTService $jwt, UsersRepository $usersRepository, EntityManagerInterface $em): Response
    {
        //Vérification si token est valide, n'a pas été modifié ni a expiré
        if ($jwt->isValid($token) && $jwt->check($token, $this->getParameter('app.jwtsecret')) && !$jwt->isExpired($token)) {

            //Récupération du payload
            $payload = $jwt->getPayload($token);
            $user = $usersRepository->find($payload['user_id']);

            //Vérification que l'utilisateur existe et n'a pas encore activé son compte
            if ($user && !$user->getIsVerified()) {
                $user->setIsVerified(true);

                $em->flush($user);

                $this->addFlash('success', 'utilisateur activé');
                return $this->redirectToRoute('app_utilisateurs_profil');
            }
        }

        $this->addFlash('danger', 'Le jeton est invalide ou a expiré');
        return $this->redirectToRoute('app_login');
    }
    #[Route('/renvoiverif', name: 'resend_verif')]
    public function resendVerif(JWTService $jwt, SendMailService $mail, UsersRepository $usersRepository): Response
    {

        $user = $this->getUser();
        if (!$user) {
            $this->addflash('danger', 'Vous devez être connecté(e) pour pouvoir accéder à cette page');
            return $this->redirectToRoute('app_login');
        }

        if ($user->getIsVerified()) {

            $this->addflash('warning', 'Ce compte utilisateur a déjà été activé.');
            return $this->redirectToRoute('app_utilisateurs_profil');
        }
        //Génération du JWT de l'utilisateur

        //Création du header
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];

        //Création du payload
        $payload = ['user_id' => $user->getId()];

        //Génération du token
        $token = $jwt->generate(
            $header,
            $payload,
            $this->getParameter(('app.jwtsecret'))
        );

        //On envoie le mail
        $mail->send(
            "no-reply@garage-parrot.fr",
            $user->getEmail(),
            'Activation de votre compte sur le site du garage Parrot',
            'register',
            compact('user', 'token')
        );

        $this->addFlash('success', "Un email de vérification a été envoyé à l'adresse que vous avez fournie, veuillez consulter la boîte de réception de votre logiciel de messagerie svp.");
        return $this->redirectToRoute('app_utilisateurs_profil');
    }
}
