<?php

namespace App\Controller\Profiles;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AlbumRepository;
use App\Repository\ImageRepository;

use App\Form\AlbumType;
use App\Form\ImageType;
use App\Entity\Album;
use App\Entity\Image;


class PhotosController extends AbstractController
{
    /**
     * @Route("/profile/photos/{albumId}", name="profile_photos")
     */
    public function index(Request $request, EntityManagerInterface $em, AlbumRepository $albumRepository, int $albumId=0): Response
    {
        $album = new Album();
        $image = new Image();

        $form = $this->createForm(AlbumType::class, $album);
        $formImage = $this->createForm(ImageType::class, $image);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $album = $form->getData();

            $em->persist($album);
            $em->flush();
        }

        
        $album = new Album();
        if ($albumId !== 0)
        {
            $album = $albumRepository->find($albumId);
        }
        $formEdit = $this->createForm(AlbumType::class, $album);

        $formEdit->handleRequest($request);
        if ($formEdit->isSubmitted() && $formEdit->isValid())
        {
            $album = $formEdit->getData();

            $em->persist($album);
            $em->flush();
        }


        $formImage->handleRequest($request);
        if ($formImage->isSubmitted() && $formImage->isValid())
        {
            $image = $formImage->getData();

            $imageFile = $formImage->get('imagepath')->getData();

            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

            //Storage
            try {
                $imageFile->move(
                    $this->getParameter('image_directory'),
                    $newFilename
                );
            } catch (FileException $e) {}

                $image->setImagepath($newFilename);
                $image->setCreatedAt(new \DateTime('now'));
                $image->setUpdatedAt(new \DateTime('now'));


                $em->persist($image);
                $em->flush();
        }

            $albums = $albumRepository->findBy(
                ["privat" => 0 ]
            );
            $albumsp = $albumRepository->findBy(
                ["privat" => 1 ]
            );

        return $this->render('profiles/photos/index.html.twig', [
            'formAlbum' => $form->createView(),
            'formImage' => $formImage->createView(),
            'formEdit' => $formEdit->createView(),
            'albums' => $albums,
            'albumsp' => $albumsp,
            'albume' => $album,
        ]);
    }

    /**
     * @Route("/profile/delete/album/{id}", name="album_delete")
     */
    public function deleteAlbum(Request $request, EntityManagerInterface $em, AlbumRepository $albumRepository, int $id)
    {
        $album = $albumRepository->find($id);

        //delete all photos before
        foreach ($album->getImages() as $image)
        {
            $file_pointer = $this->getParameter('image_directory') . '/' . $image->getImagepath();
            if(!unlink($file_pointer))
            {
                dd($file_pointer . ' cannot be deleted');
            } else {
                $em->remove($image);
            }
        }

        $em->remove($album);
        $em->flush();

        return $this->redirectToRoute('profile_photos');
    }

    /**
     * @Route("/profile/delete/photo/{id}", name="photos_delete")
     */
    public function deleteImage (Request $request, EntityManagerInterface $em, ImageRepository $imageRepository, int $id)
    {
        $image = $imageRepository->find($id);
        $file_pointer = $this->getParameter('image_directory') . '/' . $image->getImagepath();

        if(!unlink($file_pointer))
        {
            dd($file_pointer . ' cannot be deleted');
        } else {
            $em->remove($image);
            $em->flush();
        }

        return $this->redirectToRoute('profile_photos');
    }

}
