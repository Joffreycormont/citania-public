<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminUserController extends AbstractController
{
    /**
     * @Route("/administration/panel/utilisateur/{id}", name="admin_panel_user")
     * @param User $user
     * @return Response returns the page rendering of a particular user
     */
    public function index(User $user):Response
    {
        $registeredUserList = count($this->getDoctrine()->getRepository(User::class)->findAll());

        return $this->render('admin/user.html.twig', [
            'controller_name' => 'HomeController',
            'user' => $user
        ]);
    }

    /**
     * @Route("/administration/panel/utilisateurs", name="admin_panel_userList")
     * @param User $user
     * @return Response returns the page rendering of the user list (fetching with ajax request)
     */
    public function userList(UserRepository $user)
    {

        return $this->render('admin/userList.html.twig', [
            'controller_name' => 'HomeController',
            'userList' => $user->findAll()
        ]);
    }

}
