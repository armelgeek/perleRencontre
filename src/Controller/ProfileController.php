<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     */
    public function index(Security $security): Response
    {
        $user = $security->getUser();
        if ($user != null and $user instanceof Utilisateur) {
            $abonnement = $user->getAbonnement();
            return $this->render('profile/index.html.twig', [
                'abonnement' => $abonnement,
            ]);
        } else {
            return $this->redirectToRoute('app_login');
        }
    }
}