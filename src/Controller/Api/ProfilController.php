<?php

namespace App\Controller\Api;

use App\Entity\Characters;
use App\Entity\Humor;
use App\Entity\RelationStatus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

class ProfilController extends AbstractController
{
    /**
     * @Route("/api/changeHumor", name="api_changeHumor", methods={"POST"})
     */
    public function changeHumor(Request $request, Security $security)
    {
        $user = $security->getUser();
        $userId = $user->getCharacters()->getId();

        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('json' => new JsonEncoder()));
        $decodedJson = $serializer->decode($request->getContent('newHumor'), 'json');

        $newHumor = $this->getDoctrine()->getRepository(Humor::class)->find($decodedJson['newHumor']); 

        $characterTodEdit = $this->getDoctrine()->getRepository(Characters::class)->find($userId);

        $characterTodEdit->setHumor($newHumor);
        $em = $this->getDoctrine()->getManager();
        $em->persist($characterTodEdit);
        $em->flush();

        return $this->json("changement effectué");
    }

    /**
     * @Route("/api/getHumor", name="api_getHumor", methods={"POST"})
     */
    public function getHumor(Request $request, Security $security)
    {
        $user = $security->getUser();
        $userId = $user->getCharacters()->getId();

        $humor = $this->getDoctrine()->getRepository(Characters::class)->find($userId); 

        return $this->json($humor->GetHumor()->getName());
    }

        /**
     * @Route("/api/changeRelationStatus", name="api_changeRelationStatus", methods={"POST"})
     */
    public function changeRelationStatus(Request $request, Security $security)
    {
        $user = $security->getUser();
        $userId = $user->getCharacters()->getId();

        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('json' => new JsonEncoder()));
        $decodedJson = $serializer->decode($request->getContent('newRelationStatus'), 'json');

        $newRelationStatus = $this->getDoctrine()->getRepository(RelationStatus::class)->find($decodedJson['newRelationStatus']); 

        $characterTodEdit = $this->getDoctrine()->getRepository(Characters::class)->find($userId);

        $characterTodEdit->setRelationStatus($newRelationStatus);
        $em = $this->getDoctrine()->getManager();
        $em->persist($characterTodEdit);
        $em->flush();

        return $this->json("changement effectué");
    }

    /**
     * @Route("/api/getRelationStatus", name="api_getRelationStatus", methods={"POST"})
     */
    public function getRelationStatus(Request $request, Security $security)
    {
        $user = $security->getUser();
        $userId = $user->getCharacters()->getId();

        $relationStatus = $this->getDoctrine()->getRepository(Characters::class)->find($userId); 

        return $this->json($relationStatus->getRelationStatus()->getName());
    }
}
