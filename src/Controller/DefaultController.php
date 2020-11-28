<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/", name="app_")
 */
final class DefaultController extends AbstractController
{
    /**
     * @Route(name="index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('default/index.html.twig');
    }
}
