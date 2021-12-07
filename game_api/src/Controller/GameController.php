<?php

namespace App\Controller;

use JMS\Serializer\SerializerInterface;

use App\Classes\JSONResponse;
use App\Entity\User;
use App\Entity\Item;
use App\Entity\Factory;
use App\Entity\Cost;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class GameController extends AbstractController
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
     * @Route("/click/{id}", name="click_player", methods={"POST"})
     */
    public function clickPlayer(User $user): Response 
    {
        $user->clickPlayer();
        $this->getDoctrine()->getManager()->flush();

        return new Response(Response::HTTP_OK);
    }

    /**
     * @Route("/update/{id}", name="update_player", methods={"POST"})
     */
    public function updatePlayer(User $user): Response 
    {
        $user->updatePlayer();
        $this->getDoctrine()->getManager()->flush();

        return new Response(Response::HTTP_OK);
    }
}
