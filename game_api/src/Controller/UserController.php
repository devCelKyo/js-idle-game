<?php

namespace App\Controller;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use JMS\Serializer\SerializerInterface;

use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class UserController extends AbstractController
{
    private $serializer;

    public function __construct(SerializerInterface $serializer) {
        $this->serializer = $serializer;
    }

    function createResponse($object) {
        $data = $this->serializer->serialize($object, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @Route("/user", name="user_get_all", methods={"GET"})
     */
    public function getUsers(): Response
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        
        $data = $this;

        return $this->createResponse($users);
    }

    /**
     * @Route("/user/{id}", name="user_get", methods={"GET"})
     */
    public function getUser(User $user): Response
    {
        return $this->createResponse($user);
    }

    /**
     * @Route("/user/{id}", name="user_delete", methods={"DELETE"})
     */
    public function deleteUser(User $user): Response 
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return new Response(Response::HTTP_OK);
    }
}
