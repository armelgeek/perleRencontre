<?php

namespace App\Controller\Domain\Utilisateur;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use App\Entity\Utilisateur;
use App\Entity\Video;
use App\Form\VideoType;
use App\Repository\VideoRepository;
use App\Entity\Comment;
use App\Form\CommentType;


class VideoController extends AbstractController
{
    /**
     * @Route("/profile/{user}/video/{id}", name="profiles_video")
     */
    public function index(Request $request, EntityManagerInterface $em, VideoRepository $videoRepository, Utilisateur $user, int $id = 0): Response
    {
        $video = new Video();

        $form = $this->createForm(VideoType::class, $video);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $video = $form->getData();

            $videoFile = $form->get('videopath')->getData();

            $originalFilename = pathinfo($videoFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
            $newFilename = $safeFilename.'-'.uniqid().'.'.$videoFile->guessExtension();

            //Storage
            try {
                $videoFile->move(
                    $this->getParameter('video_directory'),
                    $newFilename
                );
            } catch (FileException $e) {}

            $video->setVideopath($newFilename);

            $video->setCreatedAt(new \DateTime('now'));
            $video->setUpdatedAt(new \DateTime('now'));

            $user->addVideo($video);
            $em->persist($video); 
            $em->flush();
        }

        $videoplay = new Video();
        if($id !== 0)
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

            $em->persist($comment);
            $em->flush();
        }


        return $this->render('profiles/video/index.html.twig', [
            'user' => $user,
            'videoplay' => $videoplay,
            'form' => $form->createView(),
            'form_comment' => $formComment->createView(),
        ]);
    }

    /**
     * @Route("/profile/{user}/delete/video/{id}", name="delete_video")
     */
    public function deleteVideo (Request $request, EntityManagerInterface $em, VideoRepository $videoRepository, Utilisateur $user,  int $id)
    {
        $video = $videoRepository->find($id);
        $file_pointer = $this->getParameter('video_directory') . '/' . $video->getVideopath();

        if(!unlink($file_pointer))
        {
            dd($file_pointer . ' cannot be deleted');
        } else {
            $em->remove($video);
            $em->flush();
        }

        return $this->redirectToRoute('profiles_video', [
            'user' => $user->getId(),
        ]);
    }
}
