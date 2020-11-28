<?php

declare(strict_types=1);

namespace App\Controller\Infrastructure;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/", name="app_")
 */
final class LangueController extends AbstractController
{
    /**
     * @Route("langues",name="langues", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('infrastructure/langue.html.twig');
    }
}