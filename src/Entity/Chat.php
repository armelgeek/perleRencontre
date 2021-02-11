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
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="chats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $uti_id;

    /**
     * @ORM\ManyToOne(targetEntity=Conversation::class, inversedBy="chats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $conv_id;

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

    public function getUtiId(): ?Utilisateur
    {
        return $this->uti_id;
    }

    public function setUtiId(?Utilisateur $uti_id): self
    {
        $this->uti_id = $uti_id;

        return $this;
    }

    public function getConvId(): ?Conversation
    {
        return $this->conv_id;
    }

    public function setConvId(?Conversation $conv_id): self
    {
        $this->conv_id = $conv_id;

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
