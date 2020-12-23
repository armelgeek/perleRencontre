<?php

namespace App\Entity;

use App\Repository\MonCoffreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MonCoffreRepository::class)
 */
class MonCoffre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=MonProfil::class, inversedBy="monCoffres")
     */
    private $profil;

    /**
     * @ORM\ManyToOne(targetEntity=Abonnement::class, inversedBy="coffres")
     */
    private $abonnement;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $expiredAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isExpired;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $validation_number;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $customer_id;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $transcation = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProfil(): ?MonProfil
    {
        return $this->profil;
    }

    public function setProfil(?MonProfil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }

    public function getAbonnement(): ?Abonnement
    {
        return $this->abonnement;
    }

    public function setAbonnement(?Abonnement $abonnement): self
    {
        $this->abonnement = $abonnement;

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

    public function getIsExpired(): ?bool
    {
        return $this->isExpired;
    }

    public function setIsExpired(?bool $isExpired): self
    {
        $this->isExpired = $isExpired;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
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

    public function getValidationNumber(): ?int
    {
        return $this->validation_number;
    }

    public function setValidationNumber(?int $validation_number): self
    {
        $this->validation_number = $validation_number;

        return $this;
    }

    public function getCustomerId(): ?string
    {
        return $this->customer_id;
    }

    public function setCustomerId(?string $customer_id): self
    {
        $this->customer_id = $customer_id;

        return $this;
    }

    public function getTranscation(): ?array
    {
        return $this->transcation;
    }

    public function setTranscation(?array $transcation): self
    {
        $this->transcation = $transcation;

        return $this;
    }
}
