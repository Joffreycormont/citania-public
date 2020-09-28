<?php

namespace App\Controller\Api;

use App\Entity\Actions;
use App\Entity\Characters;
use App\Entity\HasAction;
use App\Entity\Logbook;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class ActionController extends AbstractController
{
    /**
     * @Route("/api/action/newKisse/for/{id}", name="api_action_kisse")
     */
    public function newKisse(Characters $characters, Request $request, Security $security)
    {
        $user = $security->getUser();
        $userId = $user->getCharacters();

        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('json' => new JsonEncoder()));
        $decodedJson = $serializer->decode($request->getContent('kisseActionId'), 'json');

        $actionId = $decodedJson['kisseActionId'];

        $checkIfActionExist = $this->getDoctrine()->getRepository(HasAction::class)->checkAction($actionId, $userId, $characters->getId());

        if(count($checkIfActionExist) > 0){

            $data = $serializer->encode(array(
                "alert-error",
                "Tu as déjà fait un bisous à ce joueur aujourd'hui")
                , 'json');

            return new Response($data, 200, ['Content-Type' => 'application/json']);
        }

        $newHasAction = new HasAction();
        $action = $this->getDoctrine()->getRepository(Actions::class)->find($actionId);

        $newHasAction->setAction($action);
        $newHasAction->setSend($userId);
        $newHasAction->setReceiver($characters);

        // insertion d'une nouvelle entrée pour le journal de bord du receveur
        $newLogbookEntry = new Logbook();
        $newLogbookEntry->setCharacters($characters);
        $newLogbookEntry->setSend($userId);
        $newLogbookEntry->setEvent('Social');
        $newLogbookEntry->setContent('Tu as reçu un <strong>bisou</strong> de la part de '.$userId->getFirstname().' '.$userId->getLastname());

        $characters->setKisses($characters->getKisses() + 1);

        $em = $this->getDoctrine()->getManager();
        $em->persist($newHasAction);
        $em->persist($characters);
        $em->persist($newLogbookEntry);
        $em->flush();

        $data = $serializer->encode(array(
            "alert-success",
            "Bisous envoyé")
            , 'json');

        return new Response($data, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/api/action/newPunch/for/{id}", name="api_action_punch")
     */
    public function newPunch(Characters $characters, Request $request, Security $security)
    {
        $user = $security->getUser();
        $userId = $user->getCharacters();

        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('json' => new JsonEncoder()));
        $decodedJson = $serializer->decode($request->getContent('punchActionId'), 'json');

        $actionId = $decodedJson['punchActionId'];

        $checkIfActionExist = $this->getDoctrine()->getRepository(HasAction::class)->checkAction($actionId, $userId, $characters->getId());

        if(count($checkIfActionExist) > 0){

            $data = $serializer->encode(array(
                "alert-error",
                "Tu as déjà fait un coup de poing à ce joueur aujourd'hui")
                , 'json');

            return new Response($data, 200, ['Content-Type' => 'application/json']);
        }

        $newHasAction = new HasAction();
        $action = $this->getDoctrine()->getRepository(Actions::class)->find($actionId);

        $newHasAction->setAction($action);
        $newHasAction->setSend($userId);
        $newHasAction->setReceiver($characters);

        // insertion d'une nouvelle entrée pour le journal de bord du receveur
        $newLogbookEntry = new Logbook();
        $newLogbookEntry->setCharacters($characters);
        $newLogbookEntry->setSend($userId);
        $newLogbookEntry->setEvent('Social');
        $newLogbookEntry->setContent('Tu as reçu un <strong>coup de poing</strong> de la part de '.$userId->getFirstname().' '.$userId->getLastname());

        $characters->setPunchs($characters->getPunchs() + 1);

        $em = $this->getDoctrine()->getManager();
        $em->persist($newHasAction);
        $em->persist($characters);
        $em->persist($newLogbookEntry);
        $em->flush();

        $data = $serializer->encode(array(
            "alert-success",
            "Coup de poing envoyé")
            , 'json');

        return new Response($data, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/api/action/newHug/for/{id}", name="api_action_hug")
     */
    public function newHug(Characters $characters, Request $request, Security $security)
    {
        $user = $security->getUser();
        $userId = $user->getCharacters();

        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('json' => new JsonEncoder()));
        $decodedJson = $serializer->decode($request->getContent('hugActionId'), 'json');

        $actionId = $decodedJson['hugActionId'];

        $checkIfActionExist = $this->getDoctrine()->getRepository(HasAction::class)->checkAction($actionId, $userId, $characters->getId());

        if(count($checkIfActionExist) > 0){

            $data = $serializer->encode(array(
                "alert-error",
                "Tu as déjà fait un câlin à ce joueur aujourd'hui")
                , 'json');

            return new Response($data, 200, ['Content-Type' => 'application/json']);
        }

        $newHasAction = new HasAction();
        $action = $this->getDoctrine()->getRepository(Actions::class)->find($actionId);

        $newHasAction->setAction($action);
        $newHasAction->setSend($userId);
        $newHasAction->setReceiver($characters);

        // insertion d'une nouvelle entrée pour le journal de bord du receveur
        $newLogbookEntry = new Logbook();
        $newLogbookEntry->setCharacters($characters);
        $newLogbookEntry->setSend($userId);
        $newLogbookEntry->setEvent('Social');
        $newLogbookEntry->setContent('Tu as reçu un <strong>câlin</strong> de la part de '.$userId->getFirstname().' '.$userId->getLastname());

        $characters->setHugs($characters->getHugs() + 1);

        $em = $this->getDoctrine()->getManager();
        $em->persist($newHasAction);
        $em->persist($characters);
        $em->persist($newLogbookEntry);
        $em->flush();

        $data = $serializer->encode(array(
            "alert-success",
            "Câlin envoyé")
            , 'json');

        return new Response($data, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/api/action/newPinch/for/{id}", name="api_action_pinch")
     */
    public function newPinch(Characters $characters, Request $request, Security $security)
    {
        $user = $security->getUser();
        $userId = $user->getCharacters();

        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('json' => new JsonEncoder()));
        $decodedJson = $serializer->decode($request->getContent('pinchActionId'), 'json');

        $actionId = $decodedJson['pinchActionId'];

        $checkIfActionExist = $this->getDoctrine()->getRepository(HasAction::class)->checkAction($actionId, $userId, $characters->getId());

        if(count($checkIfActionExist) > 0){

            $data = $serializer->encode(array(
                "alert-error",
                "Tu as déjà fait un pincement à ce joueur aujourd'hui")
                , 'json');

            return new Response($data, 200, ['Content-Type' => 'application/json']);
        }

        $newHasAction = new HasAction();
        $action = $this->getDoctrine()->getRepository(Actions::class)->find($actionId);

        $newHasAction->setAction($action);
        $newHasAction->setSend($userId);
        $newHasAction->setReceiver($characters);

        // insertion d'une nouvelle entrée pour le journal de bord du receveur
        $newLogbookEntry = new Logbook();
        $newLogbookEntry->setCharacters($characters);
        $newLogbookEntry->setSend($userId);
        $newLogbookEntry->setEvent('Social');
        $newLogbookEntry->setContent('Tu as reçu un <strong>pincement</strong> de la part de '.$userId->getFirstname().' '.$userId->getLastname());

        $characters->setPinchs($characters->getPinchs() + 1);

        $em = $this->getDoctrine()->getManager();
        $em->persist($newHasAction);
        $em->persist($characters);
        $em->persist($newLogbookEntry);
        $em->flush();

        $data = $serializer->encode(array(
            "alert-success",
            "Pincement envoyé")
            , 'json');

        return new Response($data, 200, ['Content-Type' => 'application/json']);
    }

        /**
     * @Route("/api/action/newSmile/for/{id}", name="api_action_smile")
     */
    public function newSmile(Characters $characters, Request $request, Security $security)
    {
        $user = $security->getUser();
        $userId = $user->getCharacters();

        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('json' => new JsonEncoder()));
        $decodedJson = $serializer->decode($request->getContent('smileActionId'), 'json');

        $actionId = $decodedJson['smileActionId'];

        $checkIfActionExist = $this->getDoctrine()->getRepository(HasAction::class)->checkAction($actionId, $userId, $characters->getId());

        if(count($checkIfActionExist) > 0){

            $data = $serializer->encode(array(
                "alert-error",
                "Tu as déjà fait un sourire à ce joueur aujourd'hui")
                , 'json');

            return new Response($data, 200, ['Content-Type' => 'application/json']);
        }

        $newHasAction = new HasAction();
        $action = $this->getDoctrine()->getRepository(Actions::class)->find($actionId);

        $newHasAction->setAction($action);
        $newHasAction->setSend($userId);
        $newHasAction->setReceiver($characters);

        // insertion d'une nouvelle entrée pour le journal de bord du receveur
        $newLogbookEntry = new Logbook();
        $newLogbookEntry->setCharacters($characters);
        $newLogbookEntry->setSend($userId);
        $newLogbookEntry->setEvent('Social');
        $newLogbookEntry->setContent('Tu as reçu un <strong>sourire</strong> de la part de '.$userId->getFirstname().' '.$userId->getLastname());

        $characters->setSmiles($characters->getSmiles() + 1);

        $em = $this->getDoctrine()->getManager();
        $em->persist($newHasAction);
        $em->persist($characters);
        $em->persist($newLogbookEntry);
        $em->flush();

        $data = $serializer->encode(array(
            "alert-success",
            "Sourire envoyé")
            , 'json');

        return new Response($data, 200, ['Content-Type' => 'application/json']);
    }

        /**
     * @Route("/api/action/newPulledHair/for/{id}", name="api_action_pulledHair")
     */
    public function newPulledHair(Characters $characters, Request $request, Security $security)
    {
        $user = $security->getUser();
        $userId = $user->getCharacters();

        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('json' => new JsonEncoder()));
        $decodedJson = $serializer->decode($request->getContent('pulledHairActionId'), 'json');

        $actionId = $decodedJson['pulledHairActionId'];

        $checkIfActionExist = $this->getDoctrine()->getRepository(HasAction::class)->checkAction($actionId, $userId, $characters->getId());

        if(count($checkIfActionExist) > 0){

            $data = $serializer->encode(array(
                "alert-error",
                "Tu as déjà tiré les cheveux à ce joueur aujourd'hui")
                , 'json');

            return new Response($data, 200, ['Content-Type' => 'application/json']);
        }

        $newHasAction = new HasAction();
        $action = $this->getDoctrine()->getRepository(Actions::class)->find($actionId);

        $newHasAction->setAction($action);
        $newHasAction->setSend($userId);
        $newHasAction->setReceiver($characters);

        // insertion d'une nouvelle entrée pour le journal de bord du receveur
        $newLogbookEntry = new Logbook();
        $newLogbookEntry->setCharacters($characters);
        $newLogbookEntry->setSend($userId);
        $newLogbookEntry->setEvent('Social');
        $newLogbookEntry->setContent('Tu t\'es fait <strong>tirer les cheveux</strong> de la part de '.$userId->getFirstname().' '.$userId->getLastname());

        $characters->setPulledHair($characters->getPulledHair() + 1);

        $em = $this->getDoctrine()->getManager();
        $em->persist($newHasAction);
        $em->persist($characters);
        $em->persist($newLogbookEntry);
        $em->flush();

        $data = $serializer->encode(array(
            "alert-success",
            "Cheveux tirés")
            , 'json');

        return new Response($data, 200, ['Content-Type' => 'application/json']);
    }
}
