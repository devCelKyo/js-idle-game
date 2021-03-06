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
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, PUT, DELETE, PATCH, OPTIONS');

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
        $money = $user->getMoney();
        $user->updatePlayer();
        $diff = $user->getMoney() - $money;
        $message = "Vous avez récupéré ".$diff. " pièce(s) d'or";

        $this->getDoctrine()->getManager()->flush();

        $response = new JSONResponse();
        $response->setError(false);
        $response->setMessage($message);

        return $this->createResponse($response);
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
            if ($user->countFactory($model->getName()) < 3) {
                $factory = $model->createFactory();
                $user->pay($cost);
                $user->addFactory($factory);
    
                $error = false;
                $message = "Factory achetée avec succès.";

                $em = $this->getDoctrine()->getManager();
                $em->flush();
            }
            else {
                $error = true;
                $message = "Vous ne pouvez pas acheter plus de 3 fois la même Factory";
            }
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

    /**
     * @Route("/buy_iron/{id}", name="buy_iron", methods={"POST"})
     */
    public function buyIron(User $user, Request $request): Response 
    {
        $data = json_decode($request->getContent());
        $price = $data->price;
        $amount = $data->amount;

        $error = true;
        $message = "Pas assez de thunes";
        if ($user->getMoney() >= $price*$amount) {
            $user->removeMoney($price*$amount);
            $inventory = $user->getInventory();
            $ironAmount = $inventory->getAmounts()[0] + $amount;
            $goldAmount = $inventory->getAmounts()[1];
            $inventory->setAmounts(array($ironAmount, $goldAmount));

            $error = false;
            $message = "Vous avez bien acheté Fer x".$amount;

            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }

        $response = new JSONResponse();
        $response->setError($error);
        $response->setMessage($message);

        return $this->createResponse($response);
    }

    /**
     * @Route("/buy_gold/{id}", name="buy_gold", methods={"POST"})
     */
    public function buyGold(User $user, Request $request): Response 
    {
        $data = json_decode($request->getContent());
        $price = $data->price;
        $amount = $data->amount;

        $error = true;
        $message = "Pas assez de flouz mgl";
        if ($user->getMoney() >= $price*$amount) {
            $user->removeMoney($price*$amount);
            $inventory = $user->getInventory();
            $ironAmount = $inventory->getAmounts()[0];
            $goldAmount = $inventory->getAmounts()[1] + $amount;
            $inventory->setAmounts(array($ironAmount, $goldAmount));

            $error = false;
            $message = "Vous avez bien acheté Or x".$amount;

            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }

        $response = new JSONResponse();
        $response->setError($error);
        $response->setMessage($message);

        return $this->createResponse($response);
    }

    /**
     * @Route("/upgrade_factory/{id}", name="upgrade_factory", methods={"POST"})
     */
    public function upgradeFactory(Factory $factory): Response 
    {
        $upgradeCost = $factory->getUpgradeCost();
        $owner = $factory->getUser();

        $error = true;
        $message = "Pas assez de flouz mgl vérifie";
        if ($owner->canPay($upgradeCost)) {
            $owner->pay($upgradeCost);
            $factory->upgrade();

            $error = false;
            $message = "Ok nickel";

            $em = $this->getDoctrine()->getManager();
            $em->flush();
        }

        $response = new JSONResponse();
        $response->setError($error);
        $response->setMessage($message);

        return $this->createResponse($response);
    }

    /**
     * @Route("/get_upgrade_cost/{id}", name="get_upgrade_cost", methods={"GET"})
     */
    public function getUpgradeCost(Factory $factory): Response 
    {
        $upgradeCost = $factory->getUpgradeCost();
        $message = $upgradeCost;

        $response = new JSONResponse();
        $response->setError(false);
        $response->setMessage($message);

        return $this->createResponse($response);
    }
}   
