<?php

namespace App\Controller\Api;

use App\Entity\Actions;
use App\Entity\Characters;
use App\Entity\Jobs;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class MainApiController extends AbstractController
{
    /**
     * @Route("/api/searchCharacters", name="api_searchCharacters", methods={"POST"})
     */
    public function searchCharacters(Request $request, Security $security)
    {
        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('json' => new JsonEncoder()));
        $search = $serializer->decode($request->getContent('character'), 'json');

        $encoder = [new JsonEncoder()];
        $normalizers = array(new DateTimeNormalizer(), new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoder);

        $charactersList = $this->getDoctrine()->getRepository(Characters::class)->findBySearch($search["character"]);

        $data = $serializer->normalize($charactersList, null, [
            'attributes' => [
                'id','firstname', 'lastname'
            ]
        ]);

        $data = $serializer->encode($data, 'json');

        return new Response($data, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/api/getCharacter", name="api_getCharacter", methods={"POST"})
     */
    public function getCharacter(Request $request, Security $security)
    {
        $character = $security->getUser()->getCharacters();

        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('json' => new JsonEncoder()));

        $encoder = [new JsonEncoder()];
        $normalizers = array(new DateTimeNormalizer(), new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoder);

        $data = $serializer->normalize($character, null, [
            'attributes' => [
                'id','life', 'food', 'water', 'sickness', 'shape', 'cleanliness', 'urine', 'stools', 'waste', 'casinoCoins'
            ]
        ]);

        $data = $serializer->encode($data, 'json');

        return new Response($data, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/api/getCharacterListTown", name="api_getCharacterListTown")
     */
    public function getCharacterListTown(Security $security)
    {
        $characterList = $this->getDoctrine()->getRepository(Characters::class)->getAllCharacterConnected();
        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('json' => new JsonEncoder()));

        $encoder = [new JsonEncoder()];
        $normalizers = array(new DateTimeNormalizer(), new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoder);

        $data = $serializer->normalize($characterList, null, [
            'attributes' => [
                'id',
                'firstname',
                'lastname',
                'sexe',
                'job' => ['name', 'slug'], 
                'user' => ['id', 'isConnected'], 
                'age', 
                'visitor', 
                'humor' => ['name']
            ]
        ]);

        $data = $serializer->encode($data, 'json');

        return new Response($data, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("/api/update/characterListTown", name="api_update_characterListTown")
     */
    public function updateCharacterListTown(Security $security, Request $request)
    {
        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('json' => new JsonEncoder()));
        $filters = $serializer->decode($request->getContent('dataFilters'), 'json');

        $characterList = $this->getDoctrine()->getRepository(Characters::class)->getCharacterWithFilters($filters['characterName'], $filters['filter'], $filters['jobName']);

        $encoder = [new JsonEncoder()];
        $normalizers = array(new DateTimeNormalizer(), new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoder);

        $data = $serializer->normalize($characterList, null, [
            'attributes' => [
                'id',
                'firstname',
                'lastname',
                'sexe',
                'job' => ['name', 'slug'], 
                'user' => ['id', 'isConnected'], 
                'age', 
                'visitor', 
                'humor' => ['name']
            ]
        ]);

        $data = $serializer->encode($data, 'json');

        return new Response($data, 200, ['Content-Type' => 'application/json']);
    }    

    /**
     * @Route("/api/getActionList", name="api_getActionList")
     */
    public function getActionList(Security $security)
    {
        $actionList = $this->getDoctrine()->getRepository(Actions::class)->findAll();

        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('json' => new JsonEncoder()));

        $encoder = [new JsonEncoder()];
        $normalizers = array(new DateTimeNormalizer(), new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoder);

        $data = $serializer->normalize($actionList, null, [
            'attributes' => [
                'id',
                'name',
                'status'
            ]
        ]);

        $data = $serializer->encode($data, 'json');

        return new Response($data, 200, ['Content-Type' => 'application/json']);
    }


    /**
     * @Route("/api/getJobList", name="api_getJobList")
     */
    public function getJobList(Security $security)
    {
        $jobList = $this->getDoctrine()->getRepository(Jobs::class)->findAll();

        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('json' => new JsonEncoder()));

        $encoder = [new JsonEncoder()];
        $normalizers = array(new DateTimeNormalizer(), new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoder);

        $data = $serializer->normalize($jobList, null, [
            'attributes' => [
                'id',
                'name',
                'slug',
                'status'
            ]
        ]);

        $data = $serializer->encode($data, 'json');

        return new Response($data, 200, ['Content-Type' => 'application/json']);
    }    

}
