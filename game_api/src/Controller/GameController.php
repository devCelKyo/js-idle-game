<?php

namespace App\Controller;

use JMS\Serializer\SerializerInterface;

use App\Classes\JSONResponse;
use App\Entity\User;
use App\Entity\Item;
use App\Entity\ItemModel;
use App\Entity\Factory;
use App\Entity\FactoryModel;
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
        $response->headers->set('Access-Control-Allow-Origin', '*');

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

    /**
     * @Route("/buy_factory/{id}/{model_id}", name="buy_factory", methods={"POST"})
     */
    public function buyFactory(User $user, int $model_id): Response 
    {
        $model = $this->getDoctrine()->getRepository(FactoryModel::class)->find($model_id);
        $cost = $model->getCost();

        $error = true;
        $message = "Pas assez de thunes";
        if ($user->canPay($cost)) {
            $factory = $model->createFactory();
            $user->pay($cost);
            $user->addFactory($factory);

            $error = false;
            $message = "Factory achetée avec succès.";

            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }

        $response = new JSONResponse();
        $response->setError($error);
        $response->setMessage($message);

        return $this->createResponse($response);
    }

    /**
     * @Route("/factory", name="get_factories", methods={"GET"})
     */
    public function getFactories(): Response
    {
        $factories = $this->getDoctrine()->getRepository(FactoryModel::class)->findAll();
        
        $response = new JSONResponse();
        $response->setError(false);
        $response->setMessage($factories);

        return $this->createResponse($response);
    }
}
