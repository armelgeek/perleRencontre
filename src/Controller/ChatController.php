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
use DateTime;
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
        $customdata = [];
        foreach($data['results'] as $key => $value){

            $newdata = [
                'id' => $key,
                'photo' => $value['picture']['large'],
                'name' => $value['name']['first'].' '.$value['name']['last'],
                "text" => 'Hello world! This is a long message that needs to be truncated.'
            ];
            array_push($customdata,$newdata);

        }
        $response = new Response(json_encode($customdata));
        $response->headers->set('Content-Type', 'application/json');
        // return new JsonResponse($data);
        return $response;
    }

    /**
     * @Route("/chat/api/conversations/{uti_id}", name="api_chat_conversation")
     */
    public function getConversations($uti_id, HttpClientInterface $client)
    {
            $data = $client->request('GET', "https://randomuser.me/api/?results=20")->toArray() ?? [];
            $customdata = [];
            foreach ($data['results'] as $key => $value) {

              $newdata = [
                'id' => $key,
                'photo' => $value['picture']['large'],
                'name' => $value['name']['first'] . ' ' . $value['name']['last'],
                "text" => 'Hello world! This is a long message that needs to be truncated.'
              ];
              array_push($customdata, $newdata);
            }
            $response = new Response(json_encode($customdata));
            $response->headers->set('Content-Type', 'application/json');
            // return new JsonResponse($data);
            return $response;
    }
    /**
     * @Route("/chat/api/messages/{conv_id}", name="api_chat_messages")
     */
    public function getMessage(Request $request,$conv_id): JsonResponse
    {

      $data = [
        [
          "id" => 1,
          "author" => 'apple',
          "message" => 'Hello world! This is a long message that will hopefully get wrapped by our message bubble component! We will see how well it works.',
          "timestamp" => (new DateTime())->getTimestamp()
        ],
        [
          "id" => 2,
          "author" => 'orange',
          "message" => 'It looks like it wraps exactly as it is supposed to. Lets see what a reply looks like!',
          "timestamp" => (new DateTime())->getTimestamp()
        ],
        [
          "id" => 3,
          "author" => 'orange',
          "message" => 'Hello world! This is a long message that will hopefully get wrapped by our message bubble component! We will see how well it works.',
          "timestamp" => (new DateTime())->getTimestamp()
        ],
        [
          "id" => 4,
          "author" => 'apple',
          "message" => 'It looks like it wraps exactly as it is supposed to. Lets see what a reply looks like!',
          "timestamp" => (new DateTime())->getTimestamp()
        ],
        [
          "id" => 5,
          "author" => 'apple',
          "message" => 'Hello world! This is a long message that will hopefully get wrapped by our message bubble component! We will see how well it works.',
          "timestamp" => (new DateTime())->getTimestamp()
        ],
        [
          "id" => 6,
          "author" => 'apple',
          "message" => 'It looks like it wraps exactly as it is supposed to. Lets see what a reply looks like!',
          "timestamp" => (new DateTime())->getTimestamp()
        ],
        [
          "id" => 7,
          "author" => 'orange',
          "message" => 'Hello world! This is a long message that will hopefully get wrapped by our message bubble component! We will see how well it works.',
          "timestamp" => (new DateTime())->getTimestamp()
        ],
        [
          "id" => 8,
          "author" => 'orange',
          "message" => 'It looks like it wraps exactly as it is supposed to. Lets see what a reply looks like!',
          "timestamp" => (new DateTime())->getTimestamp()
        ],
        [
          "id" => 9,
          "author" => 'apple',
          "message" => 'Hello world! This is a long message that will hopefully get wrapped by our message bubble component! We will see how well it works.',
          "timestamp" => (new DateTime())->getTimestamp()
        ],
        [
          "id" => 10,
          "author" => 'orange',
          "message" => 'It looks like it wraps exactly as it is supposed to. Lets see what a reply looks like!',
          "timestamp" => (new DateTime())->getTimestamp()
        ]
      ];
      return new JsonResponse($data);
    }

}
