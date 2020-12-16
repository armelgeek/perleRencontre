<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class AbonnementController extends AbstractController
{
    /**
     * @Route("/abonnement", name="abonnement")
     */
    public function index(): Response
    {
        return $this->render('abonnement/index.html.twig', [
            'controller_name' => 'AbonnementController',
        ]);
    }
    /**
     * @Route("/abonnement/infos", name="abonnement_infos")
     */
    public function getInfos(Security $security)
    {
        $user = $security->getUser();
        $abonnement = null;
        if ($user instanceof Utilisateur && $user != null) {
            $abonnement = $user->getAbonnement();
        } else {
            return $this->redirectToRoute('app_login');
        }
    }
}