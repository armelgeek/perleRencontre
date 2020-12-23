<?php

namespace App\Entity;

use App\Repository\AbonnementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AbonnementRepository::class)
 */
class Abonnement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $perle;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity=MonCoffre::class, mappedBy="abonnement")
     */
    private $coffres;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duration;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $access = [];

    public function __construct()
    {
        $this->coffres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPerle(): ?int
    {
        return $this->perle;
    }

    public function setPerle(?int $perle): self
    {
        $this->perle = $perle;

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

    /**
     * @return Collection|MonCoffre[]
     */
    public function getCoffres(): Collection
    {
        return $this->coffres;
    }

    public function addCoffre(MonCoffre $coffre): self
    {
        if (!$this->coffres->contains($coffre)) {
            $this->coffres[] = $coffre;
            $coffre->setAbonnement($this);
        }

        return $this;
    }

    public function removeCoffre(MonCoffre $coffre): self
    {
        if ($this->coffres->removeElement($coffre)) {
            // set the owning side to null (unless already changed)
            if ($coffre->getAbonnement() === $this) {
                $coffre->setAbonnement(null);
            }
        }

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getAccess(): ?array
    {
        return $this->access;
    }

    public function setAccess(?array $access): self
    {
        $this->access = $access;

        return $this;
    }
}
