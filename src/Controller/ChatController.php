<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;

class ChatController extends AbstractController
{

    /**
     * @Route("/chat", name="chat")
     */
    public function index(): Response
    {
        return $this->render('chat/index.html.twig');
    }

    /**
     * @Route("/chat/api/list_connections", name="api_chat_connection")
     */
    public function getConnectedUsers(HttpClientInterface $client){
        // $data = $em->getRepository(Utilisateur::class)->findAll() ?? null;
        // $encoders = [new JsonEncoder()];
        // $normalizers = [new DateTimeNormalizer(),new ObjectNormalizer()];
        // $serializer = new Serializer($normalizers, $encoders);

        // $users = $serializer->serialize($data,'json', [
        //     'circular_reference_handler' => function ($object) {
        //         return $object->getId();
        //     }
        // ]);
        $data = $client->request('GET', "https://randomuser.me/api/?results=20")->toArray() ?? [];
        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        // return new JsonResponse($data);
        return $response;
    }

    /**
     * @Route("/chat/api/conversations/{uti_id}", name="api_chat_conversation")
     */
    public function getConversations($uti_id, Request $request): JsonResponse
    {

        return new JsonResponse();
    }
    /**
     * @Route("/chat/api/messages/{conv_id}", name="api_chat_messages")
     */
    public function getMessage(Security $security, Request $request,$conv_id): JsonResponse
    {

        return new JsonResponse();
    }

}
