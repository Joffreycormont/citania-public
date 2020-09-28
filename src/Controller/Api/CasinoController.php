<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class CasinoController extends AbstractController
{
    /**
     * @Route("/api/casino/addCasinoGamePlayed", name="api_casino_addGamePlayed")
     */
    public function addCasinoGamePlayed(Security $security)
    {   
        $character = $security->getUser()->getCharacters();
        $character->setCasinoGamePlayed($character->getCasinoGamePlayed() + 1);

        $em = $this->getDoctrine()->getManager();
        $em->persist($character);
        $em->flush();

        return $this->json('Partie lancée');
    }

    /**
     * @Route("/api/casino/betCasino", name="api_casino_bet", methods={"POST"})
     */
    public function betCasino(Security $security, Request $request)
    {   

        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('json' => new JsonEncoder()));
        $decodedJson = $serializer->decode($request->getContent('betValue'), 'json');

        $betValue = $decodedJson['betValue'];


        $character = $security->getUser()->getCharacters();
        $character->setCasinoCoins($character->getCasinoCoins() - $betValue);

        $em = $this->getDoctrine()->getManager();
        $em->persist($character);
        $em->flush();

        return $this->json('Pari pris en compte');
    }

    /**
     * @Route("/api/casino/blackjack/gains/{blackjackStatus}", name="api_casino_getGains", methods={"POST"})
     */
    public function gainsBlackjack(Security $security, Request $request, $blackjackStatus)
    {   
        $character = $security->getUser()->getCharacters();
        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('json' => new JsonEncoder()));
        $decodedJson = $serializer->decode($request->getContent('gainAmount'), 'json');

        $gainAmout = $decodedJson['gainAmount'];

        if ($blackjackStatus == "true") {
            $character->setCasinoCoins($character->getCasinoCoins() + ($gainAmout + ($gainAmout * 1.5)));    
        }elseif ($blackjackStatus == "false"){
            $character->setCasinoCoins($character->getCasinoCoins() + $gainAmout);
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($character);
        $em->flush();

        return $this->json('Gains attribués');
    }    
}

