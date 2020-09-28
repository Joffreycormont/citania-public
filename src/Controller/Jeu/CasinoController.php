<?php

namespace App\Controller\Jeu;

use App\Entity\Characters;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class CasinoController extends AbstractController
{
    /**
     * @Route("/jeu/casino", name="jeu_casino")
     */
    public function casino()
    {

        $leaderboard = $this->getDoctrine()->getRepository(Characters::class)->getLast25();
        $leaderboardP2 = $this->getDoctrine()->getRepository(Characters::class)->getLast25P2();

        return $this->render('jeu/casino/casino.html.twig', [
            'controller_name' => 'HomeGameController',
            'leaderboard' => $leaderboard,
            'leaderboardP2' => $leaderboardP2
        ]);
        
    }

    /**
     * @Route("/jeu/casino/buyCoins", name="jeu_casino_buyCoins")
     */
    public function buyCoins(Security $security, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $character = $security->getUser()->getCharacters();
        $mode = $request->request->get('mode');
        $quantity = intval($request->request->get('toCoinQuantity'));

        if($quantity <= 0 || $quantity > 10000){
            $this->addFlash('error', 'Mauvaise quantité doit se trouver entre 0 et 10 000');
            return $this->redirectToRoute('jeu_casino');
        }

        if($mode === "withMoney"){
            
            if( ($character->getMoney() - $quantity) < 0){
                $this->addFlash('error', 'Tu n\'as pas assez d\'argent');
                return $this->redirectToRoute('jeu_casino');
            }


            $character->setCasinoCoins($character->getCasinoCoins() + $quantity);
            $character->setMoney($character->getMoney() - ( 1 * $quantity));

            $em->persist($character);
        
        }elseif($mode === "withDiamond"){

            if( ($character->getDiamond() - $quantity) < 0){
                $this->addFlash('error', 'Tu n\'as pa assez de diamants');
                return $this->redirectToRoute('jeu_casino');
            }

            $character->setCasinoCoins($character->getCasinoCoins() + ( $quantity * 50 ));
            $character->setDiamond($character->getDiamond() - ( 1 * $quantity)); 

            $em->persist($character);

        }else{
            $this->addFlash('error', 'Erreur dans le choix du mode d\'achat');
            return $this->redirectToRoute('jeu_casino');
        }


        $em->flush();
        $this->addFlash('success', 'Achat effectué');
        return $this->redirectToRoute('jeu_casino');
    }


    /**
     * @Route("/jeu/casino/changeCoins", name="jeu_casino_changeCoins")
     */
    public function changeCoins(Security $security, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $character = $security->getUser()->getCharacters();
        $quantity = intval($request->request->get('toEuroQuantityCoin'));

        if($quantity <= 0){
            $this->addFlash('error', 'Mauvaise quantité doit se trouver entre 0 et 10 000');
            return $this->redirectToRoute('jeu_casino');
        }

        if($character->getCasinoCoins() - $quantity < 0){
            $this->addFlash('error', 'Tu n\'as pas assez de jetons');
            return $this->redirectToRoute('jeu_casino');
        }

        $character->setCasinoCoins($character->getCasinoCoins() - $quantity);
        $character->setMoney($character->getMoney() + $quantity);

        $em->persist($character);
        $em->flush();

        $this->addFlash('success', 'Echange effectué');
        return $this->redirectToRoute('jeu_casino');
    }


    /**
     * @Route("/jeu/casino/blackjack", name="jeu_casino_blackjack")
     */
    public function blackjack(Security $security, Request $request)
    {
        return $this->render('jeu/casino/blackjack.html.twig', [
            'controller_name' => 'HomeGameController'
        ]);
    }

}
