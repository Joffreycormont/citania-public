<?php

namespace App\Controller;

use App\Entity\CommandPremium;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PersonnalAccountController extends AbstractController
{
    /**
     * @Route("/utilisateur/mon_compte", name="personnal_account")
     * @param AuthenticationUtils $authenticationUtils
     * @param Security $security
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response return the rendering of the user account page
     */
    public function index(AuthenticationUtils $authenticationUtils, Security $security, Request $request, PaginatorInterface $paginator):Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // informations utilisateur
        $user = $security->getUser();
        $userId = $user->getId();

        $commandList = $paginator->paginate(
            $this->getDoctrine()->getRepository(CommandPremium::class)->findByUser($userId),
            $request->query->getInt('page',1),
            5
        );
        
        return $this->render('personnal_account/index.html.twig', [
            'controller_name' => 'PersonnalAccountController',
            'error' => $error,
            'last_username' => $lastUsername,
            'user' => $user,
            'commandList' => $commandList
        ]);
    }
}
