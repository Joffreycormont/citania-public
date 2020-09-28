<?php

namespace App\Controller\Api\Admin;

use App\Entity\Characters;
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

class AdminUserController extends AbstractController
{
    /**
     * @Route("api/getUserList", name="api_getUserList")
     */
    public function getUserList(UserRepository $userRepository)
    {
        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('json' => new JsonEncoder()));

        $encoder = [new JsonEncoder()];
        $normalizers = array(new DateTimeNormalizer(), new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoder);

        $data = $serializer->normalize($userRepository->findAll(), null, [
            'attributes' => [
                'id',
                'email',
                'roles',
                'characters' => [
                    'firstname',
                    'lastname',
                    'age',
                    'money',
                    'diamond',
                    'job' => [
                        'name'
                    ],
                    'createdAt'
                ],
            ]
        ]);

        $data = $serializer->encode($data, 'json');

        return new Response($data, 200, ['Content-Type' => 'application/json']);
    }

    /**
     * @Route("api/getUserListWithFilters", name="api_getUserList_with_filters", methods={"POST"})
     */
    public function getUserListWithFilters(UserRepository $userRepository, Request $request)
    {
        $serializer = new Serializer(array(new GetSetMethodNormalizer()), array('json' => new JsonEncoder()));
        $filters = $serializer->decode($request->getContent('dataFilters'), 'json');

        $newUserList = $userRepository->findWithFilters($filters['id'], $filters['email'], $filters['firstname'], $filters['lastname'], $filters['age'], $filters['job']);

        $encoder = [new JsonEncoder()];
        $normalizers = array(new DateTimeNormalizer(), new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoder);

        $data = $serializer->normalize($newUserList, null, [
            'attributes' => [
                'id',
                'email',
                'roles',
                'characters' => [
                    'firstname',
                    'lastname',
                    'age',
                    'money',
                    'diamond',
                    'job' => [
                        'name'
                    ],
                    'createdAt'
                ],
            ]
        ]);

        $data = $serializer->encode($data, 'json');

        return new Response($data, 200, ['Content-Type' => 'application/json']);
    }
}