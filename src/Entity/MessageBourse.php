<?php

namespace App\Entity;

use App\Repository\MessageBourseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageBourseRepository::class)
 */
class MessageBourse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $bourse;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class)
     */
    private $sender;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class)
     */
    private $receiver;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isAccepted;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isExpired;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $expiredAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isRefused;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBourse(): ?int
    {
        return $this->bourse;
    }

    public function setBourse(int $bourse): self
    {
        $this->bourse = $bourse;

        return $this;
    }

    public function getSender(): ?Utilisateur
    {
        return $this->sender;
    }

    public function setSender(?Utilisateur $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getReceiver(): ?Utilisateur
    {
        return $this->receiver;
    }

    public function setReceiver(?Utilisateur $receiver): self
    {
        $this->receiver = $receiver;

        return $this;
    }

    public function getIsAccepted(): ?bool
    {
        return $this->isAccepted;
    }

    public function setIsAccepted(?bool $isAccepted): self
    {
        $this->isAccepted = $isAccepted;

        return $this;
    }

    public function getIsExpired(): ?bool
    {
        return $this->isExpired;
    }

    public function setIsExpired(?bool $isExpired): self
    {
        $this->isExpired = $isExpired;

        return $this;
    }

    public function getExpiredAt(): ?\DateTimeInterface
    {
        return $this->expiredAt;
    }

    public function setExpiredAt(?\DateTimeInterface $expiredAt): self
    {
        $this->expiredAt = $expiredAt;

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

    public function getIsRefused(): ?bool
    {
        return $this->isRefused;
    }

    public function setIsRefused(?bool $isRefused): self
    {
        $this->isRefused = $isRefused;

        return $this;
    }
}
