<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\InscriptionType;
use App\Entity\Utilisateur;
use App\Repository\DepartementRepository;
use App\Repository\PaysRepository;
use App\Repository\RegionRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class SecurityController extends AbstractController
{
    /**
     * @Route("/connexion", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
     /**
     * @Route("/inscription",name="inscription", methods={"GET","POST"})
     */
    public function inscription(Request $request,PaysRepository $paysRepository,RegionRepository $regionRepository,DepartementRepository $departementRepository,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        // création du formulaire
        $utilisateur = new Utilisateur();
       
        $utilisateur->setJeCherche(['JECHERCHE_FEMME']);
        $utilisateur->setGenre(0);
        $form = $this->createForm(InscriptionType::class, $utilisateur, [
            'validation_groups' => array('User', 'registration'),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data=$form->getData();
            $data->setPays($paysRepository->find($request->get('pays')));
            $data->setRegion($regionRepository->find($request->get('region')));
            $data->setDepartement($departementRepository->find($request->get('departement')));
            $password = $passwordEncoder->encodePassword($utilisateur, $utilisateur->getPassword());
            $utilisateur->setPassword($password);
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();
           // $referer = $request->headers->get('referer');
           // return $this->redirect($referer);
            return $this->redirectToRoute('accueil');
        }
        return $this->render('security/inscription.html.twig', [
            'form' => $form->createView(),
            'pays'=>$paysRepository->findAll()
        ]);
    }
    /**
     * @Route("/mon-profil",name="monProfil", methods={"GET","POST"})
     */
    public function monProfil(Request $request): Response{
        return $this->render('security/profil.html.twig');
    }
     /**
     * @Route("/ajax-get-region",name="ajaxGetRegion", methods={"GET","POST"})
     */
    public function getRegion(Request $request,RegionRepository $regionRepository,PaysRepository $paysRepository): Response{
        $data['regions']=$regionRepository->findByPays($paysRepository->find($request->get('pays')));
        return $this->render('security/choices/region.html.twig',$data);
    }
     /**
     * @Route("/ajax-get-departement",name="ajaxGetDepartement", methods={"GET","POST"})
     */
    public function getDepartement(Request $request,RegionRepository $regionRepository,DepartementRepository $departementRepository): Response{
        $data['departements']=$departementRepository->findByRegion($regionRepository->find($request->get('region')));
        return $this->render('security/choices/departement.html.twig',$data);
    }
}
