<?php

declare(strict_types=1);

namespace App\Controller\Domain\Utilisateur;

use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\InscriptionType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
/**
 * @Route("/utilisateur", name="utilisateur_")
 */
final class InscriptionController extends AbstractController
{
    /**
     * @Route(name="inscription", methods={"GET","POST"})
     */
    public function inscription(Request $request,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        // création du formulaire
        $utilisateur = new Utilisateur();
        $form = $this->createForm(InscriptionType::class, $utilisateur, [
            'validation_groups' => array('User', 'registration'),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data=$form->getData();
            $password = $passwordEncoder->encodePassword($utilisateur, $utilisateur->getPassword());
            $utilisateur->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();
           // $referer = $request->headers->get('referer');
           // return $this->redirect($referer);
            return $this->redirectToRoute('app_index');
        }
        return $this->render('domain/utilisateur/inscription.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
