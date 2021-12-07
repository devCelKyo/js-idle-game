<?php

namespace App\Controller;

use JMS\Serializer\SerializerInterface;

use App\Classes\JSONResponse;
use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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
    public function findUser(User $user): Response
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

    /**
     * @Route("/register", name="user_register", methods={"POST"})
     */
    public function registerUser(Request $request): Response 
    {
        $data = json_decode($request->getContent());
        $username = $data->username;
        $password = $data->password;
        $money = $data->money;

        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $error = false;
        if($userRepository->findOneBy(['username' => $username])) {
            $error = true;
            $message = "Username déjà utilisé";
        }
        else {
            $user = new User();
            $user->setUsername($username);
            $user->setPlainPassword($password);
            $user->setMoney($money);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $message = "Compte crée avec succès";
        }

        $response = new JSONResponse();
        $response->setError($error);
        $response->setMessage($message);

        return $this->createResponse($response);
    }

    /**
     * @Route("/login", name="user_login", methods={"POST"})
     */
    public function checkCredentials(Request $request): Response 
    {
        $data = json_decode($request->getContent());
        $username = $data->username;
        $password = $data->password;

        $userRepository = $this->getDoctrine()->getRepository(User::class);
        if(!$userRepository->findOneBy(['username' => $username])) {
            $error = true;
            $message = "Ce compte n'existe pas.";
        }
        else {
            $user = $userRepository->findOneBy(['username' => $username]);
            if($user->checkPassword($password)) {
                $error = false;
                $message = ["message" => "Connexion réussie.", "account" => $user];
                $user->setLastUpdate(new \DateTime());
                $this->getDoctrine()->getManager()->flush();
            }
            else {
                $error = true;
                $message = "Identifiants incorrects";
            }
        }

        $response = new JSONResponse();
        $response->setError($error);
        $response->setMessage($message);

        return $this->createResponse($response);
    }
}
