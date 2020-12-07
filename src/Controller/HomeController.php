<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em): Response
    {
   /*   $user = new \App\Entity\Utilisateur();

         $username ="perle";

         $password ="perle";
         $password = $passwordEncoder->encodePassword($user, $password);

         $user->setUsername($username);
         $user->setPassword($password);
         $user->setRoles(["ROLE_SUPER_ADMIN"]);
         $em->persist($user);
         $em->flush();*/
        return $this->render('index.html.twig');
    }
}
