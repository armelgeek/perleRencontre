<?php

namespace App\Controller;

use App\Entity\AutorisedUser;
use App\Entity\Message;
use App\Entity\MessageBourse;
use App\Entity\MessagePerle;
use App\Entity\MonCoffre;
use App\Entity\MonProfil;
use App\Entity\Notification;
use App\Entity\Utilisateur;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class MessageController extends AbstractController
{
    /**
     * @Route("/message", name="message")
     */
    public function index(Security $security): Response
    {
        $user = $security->getUser();
        if ($user != null && $user instanceof Utilisateur) {
            $messages = $this->getDoctrine()->getRepository(Message::class)->findBy(array('sender' => $user),array('createdAt', 'DESC'));
            return $this->render('message/index.html.twig', [
                'messages' =>$messages
            ]);
        }
        return $this->redirectToRoute('app_login');
    }

    // Exemple url for chatting si on a l'access
    /**
     * @Route("/utilisateur/chat/{id}", name="open_chat")
     */
    public function openChat($id,Security $security){
        return new Response("Chat");
    }

    // Avant d'envoyé une message , il faut appeler la fonction hasAccess dans ProfilController pour verifier si on peut envoyé ou non
    /**
     * @Route("/utilisateur/message/send", name="send_message",methods={"POST"})
     */
    public function sendMessage(Security $security,Request $request){
        $user = $security->getUser();
        if($user != null && $user instanceof Utilisateur){
            $receiver_id = $request->request->get('receiver_id');
            $message_content = $request->request->get('message');
            $profil = $this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(array('user'=>$user));
            $receiver = $this->getDoctrine()->getRepository(Utilisateur::class)->find($receiver_id);

            $messagesSent = $this->getDoctrine()->getRepository(Message::class)->findBy(array('sender'=>$user,'receiver'=>$receiver),array('createdAt','DESC'));
            $messagesReceived = $this->getDoctrine()->getRepository(Message::class)->findBy(array('sender' => $receiver, 'receiver' => $user), array('createdAt', 'DESC'));

            $pChapter = $this->getLastChapter($messagesSent,$messagesReceived);
            $plusChapter = 0 ;
            if($pChapter['rest'] == 0){
                $plusChapter = 1 ;
            }
            $prevoiusChapter = $pChapter['chapter'];
            $currentChapter = $prevoiusChapter + $plusChapter;
            $message = new Message();
            $message->setSender($user);
            $message->setReceiver($receiver);
            $message->setMessage($message_content);
            $message->setChapitre($currentChapter);

            $profil = $this->getDoctrine()->getRepository(MonProfil::class)->findOneBy(array('user' => $user));
            $moncoffre = $this->getDoctrine()->getRepository(MonCoffre::class)->findOneBy(array('profil' => $profil));
            $sentAccess = $this->getAccess($user,$receiver);
            $receivedAccess = $this->getAccess($receiver, $user);
            // Passage au 3eme chapitre, donné des points au bout du 5 messages
            if($pChapter['rest'] == 5 && $prevoiusChapter == 3){
                if(!is_null($sentAccess) && intval($sentAccess->getExpiredAt()->diff(new DateTime())->format('%R%a')) > 0){
                    // 10 points pour le garçon
                    $moncoffre->setPoint(intval($sentAccess->getPerle())*10);
                }
                else if(!is_null($receivedAccess) && intval($receivedAccess->getExpiredAt()->diff(new DateTime())->format('%R%a')) > 0){
                    // 20 points pour la fille
                    $moncoffre->setPoint(intval($receivedAccess->getPerle()) * 20);
                }
                // sent notification for popup,
                $notification = new Notification();
                $notification->setType('point');
                $notification->setTitle('Gain des points');
                $notification->setMesssage('Bravo, la perle a été gagné car vous avez eu une vraie discussion.');
                $notification->setCreatedAt(new DateTime());
                $notification->setReceiver($profil);
                $notification->setCreatedAt(new DateTime());
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();
            // rediré apres l'envoi ou retourne dans la page chat
            $this->redirectToRoute('');
        }
        return $this->redirectToRoute('app_login');

    }

    // Verification de l'acces
    public function getAccess(Utilisateur $user, Utilisateur $receiver): ?AutorisedUser
    {
        return $this->getDoctrine()->getRepository(AutorisedUser::class)->findByUser($user,$receiver);
    }

    // obtenir la dernier chapitre de message
    public function getLastChapter($messages1, $message2):array{
        if(is_array($messages1) && is_array($message2)){
            $minimm = min(sizeof($messages1), sizeof($message2));
            $chapter = intdiv($minimm,20);
            $rest = ($minimm % 20);
            return array(
                'chapter'=>$chapter,
                'rest' =>$rest,
            );
        }
        else{
            return array(
                'chapter' => 0,
                'rest' => 0,
            );
        }
    }
}
