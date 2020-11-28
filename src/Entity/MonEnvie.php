<?php

namespace App\Entity;

use App\Repository\MonEnvieRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MonEnvieRepository::class)
 */
class MonEnvie
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
    private $envie_du_jour;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_du_jour;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="monEnvies")
     */
    private $utilisateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEnvieDuJour(): ?string
    {
        return $this->envie_du_jour;
    }

    public function setEnvieDuJour(string $envie_du_jour): self
    {
        $this->envie_du_jour = $envie_du_jour;

        return $this;
    }

    public function getDateDuJour(): ?\DateTimeInterface
    {
        return $this->date_du_jour;
    }

    public function setDateDuJour(\DateTimeInterface $date_du_jour): self
    {
        $this->date_du_jour = $date_du_jour;

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
    
}
