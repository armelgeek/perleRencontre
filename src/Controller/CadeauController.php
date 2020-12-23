<?php

namespace App\Controller;

use App\Entity\Cadeau;
use App\Entity\CadeauSent;
use App\Entity\Notification;
use App\Entity\Utilisateur;
use App\Entity\MonProfil;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class CadeauController extends AbstractController
{
    /**
     * @Route("/utilisateur/cadeau", name="cadeau")
     */
    public function index(Security $security): Response
    {
        $user = $security->getUser();
        if ($user != null && $user instanceof Utilisateur) {
            $cadeaux = $this->getDoctrine()->getRepository(MonProfil::class)->findAll();
            return $this->render('cadeau/index.html.twig', [
                'cadeau' => $cadeaux,
            ]);
        }
        $this->redirectToRoute('profil');
    }

    /**
     * @Route("/utilisateur/cadeau/commander/{id}", name="commander_cadeau")
     */
    public function commander($id,Security $security){
        $user = $security->getUser();
        if ($user != null && $user instanceof Utilisateur) {
            $profile = $this->getDoctrine()->getRepository(MonProfil::class)->findOneBy(array('user' => $user));
            $monpoint = intval($profile->getPoint());
            $cadeau = $this->getDoctrine()->getRepository(Cadeau::class)->find($id);
            $cadeaupoint = intval($cadeau->getPrice());
            if($monpoint >= $cadeaupoint){
                $restpoint = $monpoint - $cadeaupoint;

                $cadeauCommander = new CadeauSent();
                $cadeauCommander->setCadeau($cadeau);
                // User information
                $cadeauCommander->setUser($user);
                $cadeauCommander->setCreatedAt(new DateTime());

                $notif = 'Vous avez bien commandé le cadeau ' . $cadeau->getName() . ', avec ' . $cadeaupoint . ' points. Il vous reste ' . $restpoint . ' points';
                $notification = new Notification();
                $notification->setType('cadeau');
                $notification->setTitle('Cadeau commandé');
                $notification->setMesssage($notif);
                $notification->setReceiver($profile);
                $notification->setCreatedAt(new DateTime());

                // update points
                $profile->setPoint($restpoint);
                // DIminiuer  les restes disponibles
                $cadeau->setSent($cadeau->getSent()+1);

                $em = $this->getDoctrine()->getManager();
                $em->persist($cadeauCommander);
                $em->persist($notification);
                $em->persist($profile);
                $em->persist($cadeau);
                $em->flush();
                $this->addFlash('success', $notif);
                // afficher la page information de la personne
                return $this->render('cadeau/information.html.twig', [
                    'profil' => $profile,
                ]);

            }
            else{
                $this->addFlash('error','Vous n\'aavez pas assez des points pour l\'acheter');
            }
            $this->redirectToRoute('cadeau');
        }
        $this->redirectToRoute('app_login');
    }
}
