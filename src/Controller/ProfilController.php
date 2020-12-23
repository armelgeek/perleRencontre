<?php

namespace App\Controller;

use App\Entity\MessageBourse;
use App\Entity\MessagePerle;
use App\Entity\Message;
use App\Entity\MonCoffre;
use App\Entity\MonProfil;
use App\Entity\Utilisateur;
use App\Entity\Notification;
use App\Entity\AutorisedUser;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;

class ProfilController extends AbstractController
{

    /**
     * @Route("utilisateur/profil", name="profil")
     */
    public function index(Security $security): Response
    {
        $user = $security->getUser();
        if ($user != null && $user instanceof Utilisateur) {
            $profile = $this->getDoctrine()->getRepository(MonProfil::class)->findOneBy(array('user' => $user));
            $notifications = $this->getDoctrine()->getRepository(Notification::class)->findBy(array('receiver' => $profile));
            $moncoffre =  $this->getDoctrine()->getRepository(MonCoffre::class)->findOneBy(array('profil' => $profile));
            $bourse = intdiv($profile->getPerle(),5);
            $abonnement = $this->getDoctrine()->getRepository(Abonnement::class)->findAll();
            return $this->render('profil/index.html.twig', [
                'profile' => $profile,
                'moncoffre' => $moncoffre,
                'notification'=>$notifications,
                'bourse'=> $bourse,
                'abonnement' =>$abonnement
            ]);
        }
        return $this->redirectToRoute('app_login');
    }


    /**
     * @Route("profil/moncoffre", name="moncoffre")
     */
    public function moncoffre(Security $security)
    {
        $user = $security->getUser();
        if ($user != null && $user instanceof Utilisateur) {
            $profile = $this->getDoctrine()->getRepository(MonProfil::class)->findOneBy(array('user' => $user));
            $moncoffre =  $this->getDoctrine()->getRepository(MonCoffre::class)->findOneBy(array('profil' => $profile,'isExpired'=>false));
            return $this->render('profil/index.html.twig', ['moncoffre' => $moncoffre]);
        }
        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/utilisateur/message/access/{id}", name="get_access")
     */
    public function getAccess($id,Security $security)
    {
        $user = $security->getUser();
        if ($user != null && $user instanceof Utilisateur) {
            $receiver = $this->getDoctrine()->getRepository(Utilisateur::class)->find($id);
            if(!is_null($receiver)){
                $access = $this->getDoctrine()->getRepository(AutorisedUser::class)->findByUser($user, $receiver);
                if(!is_null($access)){
                    // has access
                    // Rediriger vers ce qu'on veut sur l'utilisateur for exemple to charge chat interface (cela n'existe pas dans mon tache) mais c'est à vous de le rediriger
                    return $this->redirectToRoute('open_chat', array('id'=> $id));
                }
                else{
                    $messageBourse = $this->getDoctrine()->getRepository(MessageBourse::class)->findOneBy(array('receiver' => $user, 'isExpired' => false));
                    if(!is_null($messageBourse)){
                        $messageSent = $this->getDoctrine()->getRepository(AutorisedUser::class)->findBy(array('sender', $user,'receiver'=>$receiver));
                        $messageReceived = $this->getDoctrine()->getRepository(AutorisedUser::class)->findBy(array('sender', $receiver,'receiver'=>$receiver));
                        $max = max(sizeof($messageSent),sizeof($messageReceived));
                        if($max < 5){
                            // has access
                            // Rediriger vers ce qu'on veut sur l'utilisateur for exemple to charge chat interface (cela n'existe pas dans mon tache) mais c'est à vous de le rediriger
                            return $this->redirectToRoute('open_chat', array('id' => $id));
                        }

                    }
                }
            }
            return  $this->redirectToRoute('profil');
        }
        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/utilisateur/message/stop/{id}", name="stop_access")
     */
    public function stopAccess($id,Security $security){
        $user = $security->getUser();
        if ($user != null && $user instanceof Utilisateur) {
            $receiver = $this->getDoctrine()->getRepository(MessagePerle::class)->find($id);
            if(!is_null($receiver)){
                // create notification for sender
                $notification = new Notification();
                $notification->setReceiver($receiver);
                $notification->setType('access');
                $notification->setTitle('Access bloqué');
                $notification->setMesssage($user->getUsername() . ' ne veut plus discutté avec vous');
                $notification->setCreatedAt(new DateTime());

                $message = new Message();
                $message->setSender($user);
                $message->setReceiver($receiver);
                $message->setMessage("Desolé, je ne suis pas intereseé, bon continuation");
                $message->setChapitre(1);
                $message->setCreatedAt(new DateTime());

                $access = $this->getDoctrine()->getRepository(AutorisedUser::class)->findByUser($user, $receiver);
                $em = $this->getDoctrine()->getManager();
                if(!is_null($access)){
                    $access->setIsAutorised(false);
                    $em->persist($access);
                }
                $em->persist($message);
                $em->persist($notification);
                $em->flush();
            }
        }
        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/utilisateur/messageperle/lists", name="message_perle")
     */
    public function listDemandePerle(Security $security){
        $user = $security->getUser();
        if ($user != null && $user instanceof Utilisateur) {
            $demandes = $this->getDoctrine()->getRepository(MessagePerle::class)->findBy(array('receiver' => $user));
            return $this->render('profil/perle/index.html.twig', ['demandes' => $demandes]);
        }
        return $this->redirectToRoute('app_login');
    }


    /**
     * @Route("/utilisateur/messagebourse/lists", name="message_bourse")
     */
    public function listDemandeBourse(Security $security){
        $user = $security->getUser();
        if ($user != null && $user instanceof Utilisateur) {
            $demandes = $this->getDoctrine()->getRepository(MessageBourse::class)->findBy(array('receiver' => $user));
            return $this->render('profil/bourse/index.html.twig', ['demandes' => $demandes]);
        }
        return $this->redirectToRoute('app_login');
    }


    // allow method post only
    /**
     * @Route("/utilisateur/message/perle", name="send_message_perle",methods={"POST"})
     */
    public function sendPerle(Request $request,Security $security){

        $user = $security->getUser();
        if ($user != null && $user instanceof Utilisateur) {
            if($request->isMethod('POST')){
                $receiver_id = $request->request->get('receiver_id');
                $perle = $request->request->get('perle');
                $receiver = $this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(array('id' => $receiver_id));
                $receiverProfile = $this->getDoctrine()->getRepository(MonProfil::class)->findOneBy(array('user' => $receiver));
                $profile = $this->getDoctrine()->getRepository(MonProfil::class)->findOneBy(array('user' => $user));
                if($profile->getPerle()>=intval($perle)){
                    // Create message perle
                    $messagePerle = new MessagePerle();
                    $messagePerle->setSender($user);
                    $messagePerle->setReceiver($receiver);
                    $messagePerle->setIsExpired(false);
                    $messagePerle->setIsAccepted(false);
                    $messagePerle->setIsRefused(false);
                    $messagePerle->setExpiredAt(new DateTime('now +3 days'));
                    $messagePerle->setPerle($perle);
                    $messagePerle->setCreatedAt(new DateTime());
                    $messagePerle->setUpdatedAt(new DateTime());

                    $profile->setPerle($profile->getPerle()-intval($perle));
                    // send notification to fille
                    $notification = new Notification();
                    $notification->setReceiver($receiverProfile);
                    $notification->setType('perle');
                    $notification->setTitle('Envoi perle');
                    $notification->setMesssage('Vous avez réçu ' . $perle . ' perles');
                    $notification->setCreatedAt(new DateTime());
                    // Persiste the changement
                    $access = $this->getDoctrine()->getRepository(AutorisedUser::class)->findByUser($user, $receiver);
                    if (is_null($access)) {
                        $access = new AutorisedUser();
                        $access->setUser($user);
                        $access->setReceiver($receiver);
                        $access->setCreatedAt(new DateTime());
                    }
                    $access->setPerle($perle);
                    $access->setExpiredAt(new DateTime('now +3 days'));
                    $access->setIsAutorised(false);
                    $access->setUpdatedAt(new DateTime());
                    // Persiste the changement
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($notification);
                    $em->persist($messagePerle);
                    $em->persist($profile);
                    $em->flush();
                }
                else{
                    $this->addFlash('success','Vous n\'avez plus aucune perle');
                }
            }
            return $this->redirectToRoute('profil');
        }
        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/utilisateur/messageperle/{id}", name="accepte_perle")
     */
    public function acceptePerle($id, Security $security)
    {
        $user = $security->getUser();
        if ($user != null && $user instanceof Utilisateur) {
            $messagePerle = $this->getDoctrine()->getRepository(MessagePerle::class)->findOneBy(array('id' => $id, 'receiver' => $user, 'isExpired' => false));
            if(!is_null($messagePerle)){
                $sender = $messagePerle->getSender();
                $receiver = $messagePerle->getReceiver();
                // create notification for sender
                $notification = new Notification();
                $notification->setReceiver($sender);
                $notification->setType('perle');
                $notification->setTitle('Acceptation perle');
                $notification->setMesssage($user->getUsername() . ' a accépté la perle que vous lui a envoyé.');
                $notification->setCreatedAt(new DateTime());

                $messagePerle->setIsAccepted(true);
                $em = $this->getDoctrine()->getManager();

                $access = $this->getDoctrine()->getRepository(AutorisedUser::class)->findByUser($user, $receiver);
                if (!is_null($access)) {
                    $access->setIsAutorised(true);
                    $access->setExpiredAt(new DateTime('now +3 days'));
                    $access->setUpdatedAt(new DateTime());
                    $em->persist($access);
                } else {
                    $this->addFlash('error', 'Trop tard le perle est expiré');
                }
                $em->persist($notification);
                $em->persist($messagePerle);
                $em->flush();
            }
            else{
                $this->addFlash('error', 'Trop tard le perle est expiré');
            }

            return $this->redirectToRoute('profil');
        }
        return $this->redirectToRoute('app_login');
    }

    public function refusePerle($id, Security $security)
    {
        $user = $security->getUser();
        if ($user != null && $user instanceof Utilisateur) {
            $messagePerle = $this->getDoctrine()->getRepository(MessagePerle::class)->findOneBy(array('id' => $id, 'receiver' => $user, 'isExpired' => false),array('createdAt','DESC'));
            if(!is_null($messagePerle)){
                $sender = $messagePerle->getSender();
                $receiver = $messagePerle->getReceiver();
                // create notification for sender
                $notification = new Notification();
                $notification->setReceiver($sender);
                $notification->setType('perle');
                $notification->setTitle('Refusé perle');
                $notification->setMesssage($user->getUsername() . ' a refusé la perle que vous lui a envoyé. Vous été bloqué');
                $notification->setCreatedAt(new DateTime());

                $messagePerle->setIsAccepted(false);
                $messagePerle->setIsRefused(true);
                // Persiste the changement
                // Autorised acccess to user for only 5 message
                $em = $this->getDoctrine()->getManager();

                $access = $this->getDoctrine()->getRepository(AutorisedUser::class)->findByUser($user, $receiver);
                if (!is_null($access)) {
                    $access->setIsAutorised(false);
                    $access->setUpdatedAt(new DateTime());
                    $em->persist($access);
                } else {
                    $this->addFlash('error', 'Trop tard le perle est expiré');
                }
                $em->persist($notification);
                $em->persist($messagePerle);
                $em->flush();
            }
            else{
                $this->addFlash('error', 'Trop tard le perle est expiré');
            }
            return $this->redirectToRoute('profil');
        }
        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/utilisateur/message/bourse", name="send_message_bourse",methods={"POST"})
     */
    public function sendBourse(Request $request, Security $security){
        $user = $security->getUser();
        if ($user != null && $user instanceof Utilisateur) {
            if ($request->isMethod('POST')) {
                $receiver_id = $request->request->get('receiver_id');
                $bourse = $request->request->get('bourse');
                $receiver = $this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(array('id' => $receiver_id));
                $receiverProfile = $this->getDoctrine()->getRepository(MonProfil::class)->findOneBy(array('user' => $receiver));
                $profile = $this->getDoctrine()->getRepository(MonProfil::class)->findOneBy(array('user' => $user));
                $nbperle = 5 * intval($bourse);
                if ($profile->getPerle() >= $nbperle) {
                    // Create message perle
                    $messageBourse = new MessageBourse();
                    $messageBourse->setSender($user);
                    $messageBourse->setReceiver($receiver);
                    $messageBourse->setIsExpired(false);
                    $messageBourse->setBourse($bourse);
                    $messageBourse->setIsAccepted(false);
                    $messageBourse->setIsRefused(false);
                    $messageBourse->setCreatedAt(new DateTime());
                    $messageBourse->setUpdatedAt(new DateTime());
                    $messageBourse->setExpiredAt(new DateTime('now +3 days'));

                    $profile->setPerle($profile->getPerle() - $nbperle);
                    // Autorised acccess to user for only 5 message
                    $access = $this->getDoctrine()->getRepository(AutorisedUser::class)->findByUser($user, $receiver);
                    if (is_null($access)) {
                        $access = new AutorisedUser();
                        $access->setCreatedAt(new DateTime());
                        $access->setUser($user);
                        $access->setReceiver($receiver);
                    }
                    $access->setPerle($nbperle);
                    $access->setExpiredAt(new DateTime('now +3 days'));
                    $access->setIsAutorised(false);
                    $access->setUpdatedAt(new DateTime());
                    // send notification to fille
                    $notification = new Notification();
                    $notification->setReceiver($receiverProfile);
                    $notification->setType('bourse');
                    $notification->setTitle('Envoi bourse');
                    $notification->setMesssage('Vous avez réçu '.$bourse.' bourse');
                    $notification->setCreatedAt(new DateTime());
                    // Persiste the changement
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($access);
                    $em->persist($notification);
                    $em->persist($messageBourse);
                    $em->persist($profile);
                    $em->flush();
                } else {
                    $this->addFlash('success', 'Vous n\'avez plus aucune bourse');
                }
            }
            return $this->redirectToRoute('profil');
        }
        return $this->redirectToRoute('app_login');
    }
    /**
     * @Route("/utilisateur/messagebourse/{id}", name="accepte_bourse")
     */
    public function accepteBourse($id, Security $security)
    {
        $user = $security->getUser();
        if ($user != null && $user instanceof Utilisateur) {
            $messageBourse = $this->getDoctrine()->getRepository(MessageBourse::class)->findOneBy(array('id' => $id, 'receiver' => $user, 'isExpired' => false));
            if(!is_null($messageBourse)){
                // create notification for sender
                $sender = $messageBourse->getSender();
                $receiver = $messageBourse->getReceiver();
                $notification = new Notification();
                $notification->setReceiver($sender);
                $notification->setType('bourse');
                $notification->setTitle('Acceptation bourse');
                $notification->setMesssage($user->getUsername() . ' a accépté la bourse que vous lui a envoyé.');
                $notification->setCreatedAt(new DateTime());

                $messageBourse->setIsAccepted(true);
                $em = $this->getDoctrine()->getManager();
                // Autorised acccess to user for only 5 message
                $access = $this->getDoctrine()->getRepository(AutorisedUser::class)->findByUser($user, $receiver);
                if (!is_null($access)) {
                    $access->setExpiredAt(null);
                    $access->setIsAutorised(true);
                    $access->setUpdatedAt(new DateTime());
                    $access->setExpiredAt(new DateTime('now +3 days'));
                    $em->persist($access);
                } else {
                    $this->addFlash('error', 'Trop tard le bourse est expirée');
                }
                // Persiste the changement

                $em->persist($notification);
                $em->persist($messageBourse);
                $em->flush();
            }
            else{
                $this->addFlash('error', 'Trop tard le bourse est expirée');
            }
            return $this->redirectToRoute('profil');
        }
        return $this->redirectToRoute('app_login');
    }
    /**
     * @Route("/utilisateur/messagebourse/{id}", name="accepte_bourse")
     */
    public function refuseBourse($id, Security $security)
    {
        $user = $security->getUser();
        if ($user != null && $user instanceof Utilisateur) {
            $messageBourse = $this->getDoctrine()->getRepository(MessageBourse::class)->findOneBy(array('id' => $id, 'receiver' => $user, 'isExpired' => false));
            if (!is_null($messageBourse)) {
                $em = $this->getDoctrine()->getManager();
                // create notification for sender
                $sender = $messageBourse->getSender();
                $receiver = $messageBourse->getReceiver();
                // Si message vous speciifé ici l'envoi de message
                $notification = new Notification();
                $notification->setReceiver($sender);
                $notification->setType('bourse');
                $notification->setTitle('Refus bourse');
                $notification->setMesssage($user->getUsername() . ' a refusé la bourse que vous lui a envoyé.');
                $notification->setCreatedAt(new DateTime());

                $messageBourse->setIsAccepted(false);
                $messageBourse->setIsRefused(true);

                // Autorised acccess to user for only 5 message
                $access = $this->getDoctrine()->getRepository(AutorisedUser::class)->findByUser($user, $receiver);

                if (!is_null($access)) {
                    $access->setExpiredAt(null);
                    $access->setIsAutorised(false);
                    $access->setUpdatedAt(new DateTime());
                    $em->persist($access);
                } else {
                    $this->addFlash('error', 'Trop tard le bourse est expirée');
                }
                // Persiste the changement
                $em->persist($notification);
                $em->persist($messageBourse);
                $em->flush();
            }
            else{
                $this->addFlash('error', 'Trop tard le bourse est expirée');
            }
            return $this->redirectToRoute('profil');
        }
        return $this->redirectToRoute('app_login');
    }
}