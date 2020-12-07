<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VideoRepository::class)
 */
class Video
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $videopath;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="videos")
     */
    private $utilisateur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="boolean")
     */
    private $privat;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="commented")
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity=Utilisateur::class, inversedBy="likes")
     * @ORM\JoinTable(name="video_like")
     */
    private $liker;

    /**
     * @ORM\ManyToMany(targetEntity=Utilisateur::class, inversedBy="visited")
     */
    private $viewer;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->liker = new ArrayCollection();
        $this->viewer = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVideopath(): ?string
    {
        return $this->videopath;
    }

    public function setVideopath(string $videopath): self
    {
        $this->videopath = $videopath;

        return $this;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPrivat(): ?bool
    {
        return $this->privat;
    }

    public function setPrivat(bool $privat): self
    {
        $this->privat = $privat;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setCommented($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getCommented() === $this) {
                $comment->setCommented(null);
            }
        }

        return $this;
    }
     /**
     * @return Collection|Utilisateur[]
     */
    public function getLiker(): Collection
    {
        return $this->liker;
    }

    public function addLiker(Utilisateur $liker): self
    {
        if (!$this->liker->contains($liker)) {
            $this->liker[] = $liker;
        }

        return $this;
    }

    public function removeLiker(Utilisateur $liker): self
    {
        $this->liker->removeElement($liker);

        return $this;
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getViewer(): Collection
    {
        return $this->viewer;
    }

    public function addViewer(Utilisateur $viewer): self
    {
        if (!$this->viewer->contains($viewer)) {
            $this->viewer[] = $viewer;
        }

        return $this;
    }

    public function removeViewer(Utilisateur $viewer): self
    {
        $this->viewer->removeElement($viewer);

        return $this;
    }
}
