<?php

namespace App\Entity;

use App\Repository\ChatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChatRepository::class)
 */
class Chat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $uti1;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $uti2;

    /**
     * @ORM\OneToOne(targetEntity=Conversation::class, inversedBy="chat", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $conv;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUti1(): ?Utilisateur
    {
        return $this->uti1;
    }

    public function setUti1(?Utilisateur $uti1): self
    {
        $this->uti1 = $uti1;

        return $this;
    }

    public function getUti2(): ?Utilisateur
    {
        return $this->uti2;
    }

    public function setUti2(?Utilisateur $uti2): self
    {
        $this->uti2 = $uti2;

        return $this;
    }

    public function getConv(): ?Conversation
    {
        return $this->conv;
    }

    public function setConv(Conversation $conv): self
    {
        $this->conv = $conv;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
