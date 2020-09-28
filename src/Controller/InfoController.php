<?php

namespace App\Controller;

use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class InfoController extends AbstractController
{
    /**
     * @Route("/conditions-utilisation", name="CGU")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response return rendering of terms of use page
     */
    public function CGU(AuthenticationUtils $authenticationUtils):Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('info/CGU.html.twig', [
            'controller_name' => 'InfoController',
            'error' => $error,
            'last_username' => $lastUsername
        ]);
    }

    /**
     * @Route("/nous-contacter", name="contact")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response return rendering of contact page
     */
    public function contact(AuthenticationUtils $authenticationUtils):Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('info/contact.html.twig', [
            'controller_name' => 'InfoController',
            'error' => $error,
            'last_username' => $lastUsername
        ]);
    }


    /**
     * @Route("/send-message", name="contact_send_message")
     * @param Request $request
     * @param Swift_Mailer $mailer
     */
    public function sendMessage(Request $request, Swift_Mailer $mailer)
    {

        $email = $request->request->get('email');
        $subject = $request->request->get('subject');
        $contentMessage = $request->request->get('message');


        $message = (new \Swift_Message('Citania - Nouveau message'))
        ->setFrom('j.cormont30@gmail.com')
        ->setTo('j.cormont30@gmail.com');
        $message->setBody(
            $this->renderView(
                // templates/emails/registration.html.twig
                'emails/sendMessage.html.twig',
                [
                    'email' => $email,
                    'subject' => $subject,
                    'message' => $contentMessage
                ]
            ),
            'text/html'
        )
        ;

        $mailer->send($message);

        $this->addFlash('success', 'Ton message a été envoyé avec succès.');

        return $this->redirectToRoute('home');
    }
}
