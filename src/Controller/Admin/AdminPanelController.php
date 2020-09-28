<?php

namespace App\Controller\Admin;

use App\Entity\Characters;
use App\Entity\News;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AdminPanelController extends AbstractController
{
    /**
     * @Route("/administration/panel", name="admin_panel")
     * @return Response returns the page rendering of the administrator panel home
     */
    public function index():Response
    {
        $registeredUserList = count($this->getDoctrine()->getRepository(User::class)->findAll());

        return $this->render('admin/panel.html.twig', [
            'controller_name' => 'HomeController',
            'registeredCount' => $registeredUserList
        ]);
    }

    /**
     * @Route("/administration/panel/addNews", name="admin_panel_addNews")
     * @param Request $request
     * @return RedirectResponse returns redirection after add news
     */
    public function addNews(Request $request):RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $newsTitle = $request->request->get('title');
        $newsContent = $request->request->get('content');

        if(!empty($newsTitle) && !empty($newsContent)){
            
            $newNews = new News();
            $newNews->setTitle($newsTitle);
            $newNews->setContent($newsContent);

            $characterList = $this->getDoctrine()->getRepository(Characters::class)->findAll();

            foreach($characterList as $character){
                $character->setNewsReaded(0);
                $em->persist($character);
            }

            $em->persist($newNews);
            $em->flush();

            $this->addFlash('success', 'News ajoutée avec success');
            return $this->redirectToRoute('admin_panel');
        }else{
            $this->addFlash('error', 'Tout les champs doivent être remplis');
            return $this->redirectToRoute('admin_panel');
        }
    }


}
