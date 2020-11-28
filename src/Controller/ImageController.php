<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class ImageController extends AbstractController
{
    /**
     * @Route(name="image-crop", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $img_r = imagecreatefromjpeg($request->get('img'));
        $dst_r = ImageCreateTrueColor($request->get('w'), $request->get('h'));
        imagecopyresampled($dst_r, $img_r, 0, 0, $request->get('x'),$request->get('y'),$request->get('w'),$request->get('h'),$request->get('w'),$request->get('h'));
        header('Content-type: image/jpeg');
        imagejpeg($dst_r);
        exit;
    }
}
