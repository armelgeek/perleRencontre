<?php

namespace App\Entity;

use App\Repository\MonProfilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MonProfilRepository::class)
 */
class MonProfil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Utilisateur::class, cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $perle;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $point;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cadeau;

    /**
     * @ORM\OneToMany(targetEntity=MonCoffre::class, mappedBy="profil")
     */
    private $monCoffres;

    /**
     * @ORM\OneToMany(targetEntity=Notification::class, mappedBy="receiver")
     */
    private $notifications;

    public function __construct()
    {
        $this->monCoffres = new ArrayCollection();
        $this->notifications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?Utilisateur
    {
        return $this->user;
    }

    public function setUser(?Utilisateur $user): self
    {
        $this->user = $user;

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

    public function getPoint(): ?int
    {
        return $this->point;
    }

    public function setPoint(?int $point): self
    {
        $this->point = $point;

        return $this;
    }

    public function getCadeau(): ?int
    {
        return $this->cadeau;
    }

    public function setCadeau(?int $cadeau): self
    {
        $this->cadeau = $cadeau;

        return $this;
    }

    /**
     * @return Collection|MonCoffre[]
     */
    public function getMonCoffres(): Collection
    {
        return $this->monCoffres;
    }

    public function addMonCoffre(MonCoffre $monCoffre): self
    {
        if (!$this->monCoffres->contains($monCoffre)) {
            $this->monCoffres[] = $monCoffre;
            $monCoffre->setProfil($this);
        }

        return $this;
    }

    public function removeMonCoffre(MonCoffre $monCoffre): self
    {
        if ($this->monCoffres->removeElement($monCoffre)) {
            // set the owning side to null (unless already changed)
            if ($monCoffre->getProfil() === $this) {
                $monCoffre->setProfil(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Notification[]
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setReceiver($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getReceiver() === $this) {
                $notification->setReceiver(null);
            }
        }

        return $this;
    }
}
