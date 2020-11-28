<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Utilisateur;
use App\Form\RechercheRapideType;
use App\Repository\UtilisateurRepository;
final class AppController extends AbstractController
{
    /**
     * @Route("/",name="index",  methods={"GET","POST"})
     */
    public function index(Request $request,UtilisateurRepository $utilisateurRepository): Response
    {
        $rechercheRapide = $this->createForm(RechercheRapideType::class);
        
      
       // dd($query);
    //  dd($utilisateurRepository->findByRoleWrongWay('ADMIN'));
        return $this->render('index.html.twig',[
            'formRechercheRapide' => $rechercheRapide->createView()
        ]);
    }
    /**
     * @Route("/recherche",name="recherche",  methods={"GET","POST"})
     */
    public function rechercheRapide(Request $request,UtilisateurRepository $utilisateurRepository){
         $rechercheRapide = $this->createForm(RechercheRapideType::class);
        $utilisateurs=null;
        $rechercheRapide->handleRequest($request);
        if ($rechercheRapide->isSubmitted() && $rechercheRapide->isValid()) {
            $data=$rechercheRapide->getData();
            $role = mb_strtoupper($data->getRoles());
            $utilisateurs = $utilisateurRepository->createQueryBuilder('row')
            ->andWhere('JSON_CONTAINS(row.roles, :role) = 1')
            ->setParameter('role', '"ROLE_' . $role . '"')
            ->getQuery()
            ->getResult();

        }
        return $this->render('recherche.html.twig',[
            'formRechercheRapide' => $rechercheRapide->createView(),
            'utilisateurs' => $utilisateurs
        ]);
    }

}
