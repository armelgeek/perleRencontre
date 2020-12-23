<?php

namespace App\Controller;

use App\Entity\Abonnement;
use App\Entity\MonCoffre;
use App\Entity\MonProfil;
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
use DateTime;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use function PHPSTORM_META\type;

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

        // return new Response(json_encode($request->request));
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
    public function inscription(Request $request, PaysRepository $paysRepository, RegionRepository $regionRepository, DepartementRepository $departementRepository, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        // création du formulaire
        $utilisateur = new Utilisateur();
        $profile = new MonProfil();
        $moncoffre = new MonCoffre();

        $utilisateur->setJeCherche(['JECHERCHE_FEMME']);
        $utilisateur->setGenre(0);
        $form = $this->createForm(InscriptionType::class, $utilisateur, [
            'validation_groups' => array('User', 'registration'),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $data->setPays($paysRepository->find($request->get('pays')));
            $data->setRegion($regionRepository->find($request->get('region')));
            $data->setDepartement($departementRepository->find($request->get('departement')));
            $password = $passwordEncoder->encodePassword($utilisateur, $utilisateur->getPassword());
            $utilisateur->setPassword($password);

            // Abonnement par defaut
            $default_abonnement = $this->getDoctrine()->getRepository(Abonnement::class)->findOneBy(array('name' => 'Defaut'));

            $profile->setUser($utilisateur);
            $profile->setPoint(0);
            $profile->setCadeau(0);
            $profile->setPerle($default_abonnement->getPerle()); //  perle par defaut pour l'inscription

            // initialisation de mon coffre avec l'abonnement par defaut gratuit
            $moncoffre->setProfil($profile);
            $moncoffre->setValidationNumber(1);
            $moncoffre->setAbonnement($default_abonnement);
            $moncoffre->setIsExpired(false);
            $moncoffre->setExpiredAt(new DateTime('now +30 days'));
            $moncoffre->setCreatedAt(new DateTime());
            $moncoffre->setUpdatedAt(new DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->persist($profile);
            $em->persist($moncoffre);
            $em->flush();
            // $referer = $request->headers->get('referer');
            // return $this->redirect($referer);
            return $this->redirectToRoute('accueil');
        }
        return $this->render('security/inscription.html.twig', [
            'form' => $form->createView(),
            'pays' => $paysRepository->findAll(),
            'regions' => $regionRepository->findAll(),
            'departements' => $departementRepository->findAll()
        ]);
    }
    /**
     * @Route("/mon-profil",name="monProfil", methods={"GET","POST"})
     */
    public function monProfil(Request $request): Response
    {
        return $this->render('security/profil.html.twig');
    }
    /**
     * @Route("/ajax-get-region",name="ajaxGetRegion", methods={"GET","POST"})
     */
    public function getRegion(Request $request, RegionRepository $regionRepository, PaysRepository $paysRepository): Response
    {
        $data['regions'] = $regionRepository->findByPays($paysRepository->find($request->get('pays')));
        return $this->render('security/choices/region.html.twig', $data);
    }
    /**
     * @Route("/ajax-get-departement",name="ajaxGetDepartement", methods={"GET","POST"})
     */
    public function getDepartement(Request $request, RegionRepository $regionRepository, DepartementRepository $departementRepository): Response
    {
        $data['departements'] = $departementRepository->findByRegion($regionRepository->find($request->get('region')));
        return $this->render('security/choices/departement.html.twig', $data);
    }
}