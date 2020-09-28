<?php

namespace App\Controller\Api;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class connectedCountController extends AbstractController
{
    /**
     * @Route("/api/connectedCount", name="api_connected_controler")
     */
    public function connectedCount()
    {
        $connectedUserList = $this->getDoctrine()->getRepository(User::class)->getAllUserConnected();
        $connectedCount = count($connectedUserList);

        return $this->json($connectedCount);
    }
}
