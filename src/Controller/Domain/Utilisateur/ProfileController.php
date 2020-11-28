<?php

declare(strict_types=1);

namespace App\Controller\Domain\Utilisateur;

use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\PhotoCouvertureType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\PhotoCouverture;
use App\Repository\PhotoCouvertureRepository;
use App\Repository\AlbumRepository;
use App\Repository\ImageRepository;
use App\Repository\VideoRepository;
use App\Exception\FormException;
use App\Http\ApiResponse;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use App\Form\EnvieDuJourType;
use App\Form\AlbumType;
use App\Form\VideoType;
use App\Form\MonPhysiqueType;
use App\Form\CommentType;
use App\Form\DescriptionType;
use App\Form\ImageType;
use App\Entity\Album;
use App\Entity\Image;
use App\Entity\Video;
use App\Entity\Comment;

/**
 * @Route("/utilisateur", name="utilisateur_")
 */
final class ProfileController extends AbstractController
{
    /**
     * @Route("/profile",name="profile", methods={"GET","POST"})
     */
    public function profile(Request $request,PhotoCouvertureRepository $photoCouvertureRepository,AlbumRepository $albumRepository,ImageRepository $imageRepository,VideoRepository $videoRepository): Response
    {

        $user=$this->getUser();
        // Mon physique
        $formMonPhysique = $this->createForm(MonPhysiqueType::class, $user);
        $formMonPhysique->handleRequest($request);
        if ($formMonPhysique->isSubmitted() && $formMonPhysique->isValid()) {
            $data=$formMonPhysique->getData();
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('utilisateur_profile');
        }
        // Description
         if($user->getDescription()!=null ){
           $formDescription = $this->createForm(DescriptionType::class, $user);
        }else{
            $formDescription = $this->createForm(DescriptionType::class);
        }
        $formDescription->handleRequest($request);
        if ($formDescription->isSubmitted() && $formDescription->isValid()) {
            $data=$formDescription->getData();
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('utilisateur_profile');
        }
       // Video
        $videoId=0;
        $video = new Video();

        $formVideo = $this->createForm(VideoType::class, $video);

        $formVideo->handleRequest($request);
        if ($formVideo->isSubmitted() && $formVideo->isValid())
        {
            $video = $formVideo->getData();

            $videoFile = $formVideo->get('videopath')->getData();

            $originalVideoFilename = pathinfo($videoFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeVideoFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalVideoFilename);
            $newVideoFilename = $safeVideoFilename.'-'.uniqid().'.'.$videoFile->guessExtension();

            //Storage
            try {
                $videoFile->move(
                    $this->getParameter('video_directory'),
                    $newVideoFilename
                );
            } catch (FileException $e) {}

            $video->setVideopath($newVideoFilename);

            $video->setCreatedAt(new \DateTime('now'));
            $video->setUpdatedAt(new \DateTime('now'));

            $user->addVideo($video);
            $em = $this->getDoctrine()->getManager();
            $em->persist($video); 
            $em->flush();
        }

        $videoplay = new Video();
        if($videoId !== 0)
        {
            $videoplay = $videoRepository->find($id);
        }

        $comment = new Comment();
        $formComment = $this->createForm(CommentType::class, $comment);

        $formComment->handleRequest($request);
        if ($formComment->isSubmitted() && $formComment->isValid())
        {
            $comment = $formComment->getData();
            $comment->setCommenter($this->getUser());
            $videoplay->addComment($comment);
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
        }






      // Album photo
         $album = new Album();
        $image = new Image();
        $albumId=0;
        $formAlbum = $this->createForm(AlbumType::class, $album);
        $formImage = $this->createForm(ImageType::class, $image);
        $formAlbum->handleRequest($request);
        if ($formAlbum->isSubmitted() && $formAlbum->isValid())
        {
            $album = $formAlbum->getData();
            $album->setUtilisateur($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($album);
            $em->flush();
        }
        $formEditAlbum = $this->createForm(AlbumType::class, $album);

        if ($albumId !== 0)
        {
            $albumedit = $albumRepository->find($albumId);
            
            $formEditAlbum = $this->createForm(AlbumType::class, $albumedit);

            $formEditAlbum->handleRequest($request);
            if ($formEditAlbum->isSubmitted() && $formEditAlbum->isValid())
            {
                $album = $formEditAlbum->getData();
                $album->setUtilisateur($user);
                $em = $this->getDoctrine()->getManager();
                $em->persist($albumedit);
                $em->flush();
            }
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
                $image->setUtilisateur($user);
                $em = $this->getDoctrine()->getManager();
                $em->persist($image);
                $em->flush();
        }

        $albums = $albumRepository->findBy(
                ["privat" => 0,"utilisateur" => $user]
        );
        $albumsp = $albumRepository->findBy(
                ["privat" => 1,"utilisateur" => $user ]
        );
      // Envie du jour
         if($user->avoirUnEnvieDuJour()){
         $formEnvieDuJour = $this->createForm(EnvieDuJourType::class, $user->envieDuJour());
        }else{
            $formEnvieDuJour = $this->createForm(EnvieDuJourType::class);
        }
        $formEnvieDuJour->handleRequest($request);
        if ($formEnvieDuJour->isSubmitted() && $formEnvieDuJour->isValid()) {
            $data=$formEnvieDuJour->getData();
            if(!$user->avoirUnEnvieDuJour()){
            $data->setDateDuJour(new \Datetime('now'));
            }
            $data->setUtilisateur($user);
            $em = $this->getDoctrine()->getManager();
            if(!$user->avoirUnEnvieDuJour()){
                $em->persist($data);
            }
            $em->flush();
            return $this->redirectToRoute('utilisateur_profile');
        }

        if($request->get('pdc_id')){
            $changePdc=$photoCouvertureRepository->find($request->get('pdc_id'));
             foreach ($user->getPhotoCouverture() as $pcl) {
                if($pcl->getId()==$changePdc->getId()){
                $pcl->setIsActive(true);
                }else{
                $pcl->setIsActive(false);
                }
                $em = $this->getDoctrine()->getManager();
                $em->flush();
            }
            return $this->redirectToRoute('utilisateur_profile');
        }
       
        $formChangerPhotoDeProfil = $this->createForm(PhotoCouvertureType::class);
        $formChangerPhotoDeProfil->handleRequest($request);
        if ($formChangerPhotoDeProfil->isSubmitted() && $formChangerPhotoDeProfil->isValid()) {
            foreach ($user->getPhotoCouverture() as $pcl) {
                $pcl->setIsActive(false);
                $em = $this->getDoctrine()->getManager();
                $em->flush();
            }
            $data=$formChangerPhotoDeProfil->getData();
            $data->setIsActive(true);
            $data->setUtilisateur($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($data);
            $em->flush();
            return $this->redirectToRoute('utilisateur_profile');
           
        }
        return $this->render('domain/utilisateur/profile.html.twig',[
            'formAlbum' => $formAlbum->createView(),
            'formImage' => $formImage->createView(),
            'formEditAlbum' => $formEditAlbum->createView(),
            'albums' => $albums,
            'albumsp' => $albumsp,
            'albume' => $album,
            'lastImages' => $imageRepository->getLastImages($user),
            'lastVideos' => $videoRepository->getLastVideos($user),
            'user' => $user,
            'videoplay' => $videoplay,
            'formVideo' => $formVideo->createView(),
            'formMonPhysique' => $formMonPhysique->createView(),
            'form_comment' => $formComment->createView(),
            'formChangerPhotoDeProfil' => $formChangerPhotoDeProfil->createView(),
            'formEnvieDuJour' => $formEnvieDuJour->createView(),
            'photoCouvertures' => $user->getPhotoCouverture(),
            'avoirEnvie' => $user->avoirUnEnvieDuJour(),
            'envieDuJour' => $user->envieDuJour(),
            'formDescription' => $formDescription->createView(),
            'pdc' => $photoCouvertureRepository->PhotoCouvertureActive($user),

        ]);
    }
   
}
