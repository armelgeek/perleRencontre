<?php

namespace App\Controller;

use App\Repository\ConversationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Repository\UtilisateurRepository;
use DateTime;
class ChatController extends AbstractController
{
    /**
     * @Route("/chat", name="chat")
     */
    public function index(): Response
    {
        return $this->render('chat/index.html.twig');
    }
    public function serializeData($data)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new DateTimeNormalizer(), new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        return  $serializer->serialize($data, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
    }
    /**
     * @Route("/chat/api/list_connections", name="api_chat_connection")
     */
    public function getConnectedUsers(UtilisateurRepository $repoUti)
    {
        $id = 1;
        $users = $repoUti->getConnected($id);
        $jsonusers = $this->serializeData($users);
        $response = new Response($jsonusers);
        $response->headers->set('Content-Type', 'application/json');
        // return new JsonResponse($data);
        return $response;
    }

    /**
     * @Route("/chat/api/conversations/{uti_id}", name="api_chat_conversation")
     */
    public function getConversations($uti_id, UtilisateurRepository $repoUti)
    {
        $user = $repoUti->getUserById($uti_id);
        $jsondata = json_encode([]);
        if($user != null){
            $converations = $user->getConversations();
            $jsondata = $this->serializeData($converations);
        }
        $response = new Response($jsondata);
        $response->headers->set('Content-Type', 'application/json');
        // return new JsonResponse($data);
        return $response;
    }
    /**
     * @Route("/chat/api/messages/{conv_id}", name="api_chat_messages")
     */
    public function getMessage(ConversationRepository $repoConv,$conv_id)
    {

        $converastion = $repoConv->findOneBy(array('id'=> $conv_id));
        $jsondata = json_encode([]);
        if($converastion != null){
            $data = $converastion->getMessages();
            // $data = $repoConv->getMessages($conv_id);
            $jsondata = $this->serializeData($data);
        }
        $response = new Response($jsondata);
        $response->headers->set('Content-Type', 'application/json');
        // return new JsonResponse($data);
        return $response;
    }
}
