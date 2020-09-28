<?php

namespace App\Controller\Jeu;

use App\Entity\Actions;
use App\Entity\Advertising;
use App\Entity\Characters;
use App\Entity\Jobs;
use App\Entity\Logbook;
use App\Entity\News;
use App\Entity\RobotTown;
use App\Entity\User;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class HomeGameController extends AbstractController
{
    /**
     * @Route("/jeu/news", name="jeu_news")
     * @param Security $security
     * @return Response returns rendering of the news page
     */
    public function index(Security $security):Response
    {
        $user = $security->getUser();
        $character = $user->getCharacters();

        $character->setNewsReaded(1);
        // pour l'affichage des news
        $newsList = $this->getDoctrine()->getRepository(News::class)->findAllByDesc();

        $em = $this->getDoctrine()->getManager();
        $em->persist($character);
        $em->flush();


        return $this->render('jeu/home_game/index.html.twig', [
            'controller_name' => 'HomeGameController',
            'newsList' => $newsList,
            'ws_url' => 'localhost:8080',
        ]);
    }

    /**
     * @Route("/jeu/guide", name="jeu_help")
     * @return Response returns rendering of the guidebook page
     */
    public function guide():Response
    {

        return $this->render('jeu/home_game/guide.html.twig', [
            'controller_name' => 'HomeGameController',
        ]);
    }


    /**
     * @Route("/jeu/plan_de_la_ville", name="jeu_map")
     * @return Response returns rendering of the map page
     */
    public function map():Response
    {

        return $this->render('jeu/home_game/map.html.twig', [
            'controller_name' => 'HomeGameController'
        ]);
    }

    /**
     * @Route("/jeu/centre_ville", name="jeu_town")
     * @param Security $security
     * @param Request $request
     * @return Response returns rendering of the towncenter page
     */
    public function town(Security $security, Request $request):Response
    {

        if(empty($request->request->get('filter'))){
            $allUserConnected = $this->getDoctrine()->getRepository(User::class)->getAllUserConnected();
            $advertisingList = $this->getDoctrine()->getRepository(Advertising::class)->getLimitAdvertisingList();
            $BotList = $this->getDoctrine()->getRepository(RobotTown::class)->findAll();

            return $this->render('jeu/home_game/town.html.twig', [
                'controller_name' => 'HomeGameController',
                'advertisingList' => $advertisingList,
                'connectedUsers' => $allUserConnected,
                'botList' => $BotList
            ]);
        }

    }

    /**
     * @Route("/jeu/centre_ville/annonce/{id}", name="jeu_town_advertising_toSee")
     * @param Advertising $advertising
     * @return Response returns rendering of one ad page
     */
    public function advertising(Advertising $advertising):Response
    {

        return $this->render('jeu/home_game/advertising.html.twig', [
            'controller_name' => 'HomeGameController',
            'ad' => $advertising
        ]);
    }


    /**
     * @Route("/jeu/centre_ville/nouvelle_annonce", name="jeu_town_advertising")
     * @return Response return rendering of the page to add new ad
     */
    public function newAdvertisingView():Response
    {

        return $this->render('jeu/home_game/newAdvertising.html.twig', [
            'controller_name' => 'HomeGameController',
        ]);
    }

    /**
     * @Route("/jeu/centre_ville/nouvelle_annonce/adding", name="jeu_town_new_advertising", methods={"POST"})
     * @param Security $security
     * @param Request $request
     * @return RedirectResponse returns redirect after add ad
     */
    public function newAdvertising(Security $security, Request $request):RedirectResponse
    {
        $user = $security->getUser();
        $userId = $user->getCharacters()->getId();
        $em = $this->getDoctrine()->getManager();

        // vérification de la possession des diamants
        if($user->getCharacters()->getDiamond() >= 5){
            $userToUpdate = $user->getCharacters();
            $userToUpdate->setDiamond($userToUpdate->getDiamond() - 5);
            $em->persist($userToUpdate);
        }else{
            $this->addFlash('error', 'Tu n\'a pas assez de diamant, tu peux t\'en procurer d\'avantage via l\'onglet premium');
            return $this->redirectToRoute('jeu_town_advertising');
        }

        $title = $request->request->get('title');

        if(empty($title)){
            $this->addFlash('error', 'Tu as oublié de préciser le titre de ton annonce');
            return $this->redirectToRoute('jeu_town_advertising');
        }

        $content = $request->request->get('content');

        $newAd = new Advertising();
        $newAd->setTitle($title);
        $newAd->setContent($content);

        $character = $this->getDoctrine()->getRepository(Characters::class)->find($userId);

        $newAd->setCharacters($character);
        $em->persist($newAd);
        $em->flush();

        $this->addFlash('success', 'Ton annonce a été publiée avec succès');
        return $this->redirectToRoute('jeu_town_advertising');
    }

    /**
     * @Route("/jeu/journal_de_bord", name="jeu_logBook")
     * @param Security $security
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response returns rendering of logbook
     */
    public function logbook(Security $security, PaginatorInterface $paginator, Request $request):Response
    {
        $user = $security->getUser();
        $userId = $user->getCharacters()->getId();

        $logbookList = $paginator->paginate(
            $this->getDoctrine()->getRepository(Logbook::class)->findByReceiver($userId),
            $request->query->getInt('page',1),
            10
        );

        $logbookListUnRead = $this->getDoctrine()->getRepository(Logbook::class)->getUnReadEvent($userId);

        $em = $this->getDoctrine()->getManager();

        foreach($logbookListUnRead as $event){
            $event->setStatus(1);
            $em->persist($event);
        }

        $em->flush();


        return $this->render('jeu/home_game/logBook.html.twig', [
            'controller_name' => 'HomeGameController',
            'logbookList' => $logbookList
        ]);
    }

}
