<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;



/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Video::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commented;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commenter;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCommented(): ?Video
    {
        return $this->commented;
    }

    public function setCommented(?Video $commented): self
    {
        $this->commented = $commented;

        return $this;
    }

    public function getCommenter(): ?Utilisateur
    {
        return $this->commenter;
    }

    public function setCommenter(?Utilisateur $commenter): self
    {
        $this->commenter = $commenter;

        return $this;
    }
}
