<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 * @UniqueEntity(fields="username", message="Cet utilisateur  déjà utilisé.")
 */
class Utilisateur implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
    * @ORM\Column(type="string", length=180, unique=true)
    * @Assert\NotBlank
    * @Assert\Length(min="3")
    */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $genre;
    /**
     * @ORM\Column(type="json")
     */
    private $jeCherche = [];

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_naissance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PhotoCouverture", mappedBy="utilisateur")
     */
    private $photo_couverture;
     /**
     * @ORM\OneToMany(targetEntity=Video::class, mappedBy="utilisateur")
     */
    private $videos;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="commenter")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=MonEnvie::class, mappedBy="utilisateur")
     */
    private $monEnvies;

    /**
     * @ORM\OneToMany(targetEntity=Image::class, mappedBy="utilisateur")
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity=Album::class, mappedBy="utilisateur")
     */
    private $albums;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $age=0;

    /**
     * @ORM\Column(type="json")
     */
    private $couleur_de_cheveux = [];

    /**
     * @ORM\Column(type="json")
     */
    private $degaine = [];

    /**
     * @ORM\Column(type="json")
     */
    private $sexualite = [];

   
    /**
     * @ORM\Column(type="integer")
     */
    private $taille;
    /**
     * @ORM\Column(type="json")
     */
    private $style_de_cheveux = [];

    /**
     * @ORM\Column(type="json")
     */
    private $silouhette = [];

    /**
     * @ORM\Column(type="json")
     */
    private $j_ai_un_faible_pour = [];

    /**
     * @ORM\Column(type="integer")
     */
    private $poids;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $couleur_des_yeux;

    /**
     * @ORM\Column(type="json")
     */
    private $origines;

    /**
     * @ORM\Column(type="json")
     */
    private $j_aime_porter_ou_pas = [];

    /**
     * @ORM\Column(type="json")
     */
    private $je_frissone_pour = [];

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $passions_au_lit;

    /**
     * @ORM\Column(type="json")
     */
    private $proffessions = [];

    /**
     * @ORM\Column(type="json")
     */
    private $sports = [];

    /**
     * @ORM\Column(type="json")
     */
    private $hobbies = [];

    /**
     * @ORM\Column(type="json")
     */
    private $alcool = [];

    /**
     * @ORM\Column(type="json")
     */
    private $tabac = [];

    /**
     * @ORM\Column(type="json")
     */
    private $alimentation = [];

    /**
     * @ORM\Column(type="json")
     */
    private $j_aime_manger = [];

    /**
     * @ORM\Column(type="json")
     */
    private $scolarite = [];

    /**
     * @ORM\Column(type="json")
     */
    private $langues = [];

    /**
     * @ORM\Column(type="json")
     */
    private $signe_astrologique = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $avec_ou_sans_enfant=false;

    /**
     * @ORM\Column(type="json")
     */
    private $gout_musicaux = [];

    /**
     * @ORM\Column(type="json")
     */
    private $religions = [];

    /**
     * @ORM\Column(type="json")
     */
    private $personalite = [];


    public function __construct()
    {
        $this->photo_couverture = new ArrayCollection();
        $this->monEnvies = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->albums = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getJeCherche(): array
    {
        $jeCherche = $this->jeCherche;
        $jeCherche[] = 'JECHERCHE_HOMME';

        return array_unique($jeCherche);
    }

    public function setJeCherche(array $jeCherche): self
    {
        $this->jeCherche = $jeCherche;

        return $this;
    }


    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getGenre(): ?bool
    {
        return $this->genre;
    }

    public function setGenre(bool $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getDateNaissance(): ?\DateTime
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTime $date_naissance): self
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection|PhotoCouverture[]
     */
    public function getPhotoCouverture(): Collection
    {
        return $this->photo_couverture;
    }

    public function addPhotoCouverture(PhotoCouverture $photoCouverture): self
    {
        if (!$this->photo_couverture->contains($photoCouverture)) {
            $this->photo_couverture[] = $photoCouverture;
            $photoCouverture->setUtilisateur($this);
        }

        return $this;
    }

    public function removePhotoCouverture(PhotoCouverture $photoCouverture): self
    {
        if ($this->photo_couverture->contains($photoCouverture)) {
            $this->photo_couverture->removeElement($photoCouverture);
            // set the owning side to null (unless already changed)
            if ($photoCouverture->getUtilisateur() === $this) {
                $photoCouverture->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MonEnvie[]
     */
    public function getMonEnvies(): Collection
    {
        return $this->monEnvies;
    }

    public function addMonEnvy(MonEnvie $monEnvy): self
    {
        if (!$this->monEnvies->contains($monEnvy)) {
            $this->monEnvies[] = $monEnvy;
            $monEnvy->setUtilisateur($this);
        }

        return $this;
    }

    public function removeMonEnvy(MonEnvie $monEnvy): self
    {
        if ($this->monEnvies->removeElement($monEnvy)) {
            // set the owning side to null (unless already changed)
            if ($monEnvy->getUtilisateur() === $this) {
                $monEnvy->setUtilisateur(null);
            }
        }

        return $this;
    }
    public function avoirUnEnvieDuJour(){
        foreach ($this->monEnvies as $envie) {
            if(date_diff($envie->getDateDuJour(),new \Datetime('now'))){
               return true;
               break;
            }else{
                return false;
            }
        }
    }
     public function envieDuJour(){
        foreach ($this->monEnvies as $envie) {
          if(date_diff($envie->getDateDuJour(),new \Datetime('now'))){
               return $envie;
               break;
            }else{
                return null;
            }
        }
    }

    /**
     * @return Collection|Video[]
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setUtilisateur($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->videos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getUtilisateur() === $this) {
                $video->setUtilisateur(null);
            }
        }

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
            $comment->setCommenter($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getCommenter() === $this) {
                $comment->setCommenter(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setUtilisateur($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getUtilisateur() === $this) {
                $image->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Album[]
     */
    public function getAlbums(): Collection
    {
        return $this->albums;
    }

    public function addAlbum(Album $album): self
    {
        if (!$this->albums->contains($album)) {
            $this->albums[] = $album;
            $album->setUtilisateur($this);
        }

        return $this;
    }

    public function removeAlbum(Album $album): self
    {
        if ($this->albums->removeElement($album)) {
            // set the owning side to null (unless already changed)
            if ($album->getUtilisateur() === $this) {
                $album->setUtilisateur(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getCouleurDeCheveux(): ?array
    {
         $couleurs=$this->couleur_de_cheveux;
         $couleurs[] = 'COULEUR_DES_CHEVEUX_NOIR';

        return array_unique($couleurs);
    }

    public function setCouleurDeCheveux(array $couleur_de_cheveux): self
    {
        $this->couleur_de_cheveux = $couleur_de_cheveux;
     
        return $this;
    }

    public function getDegaine(): ?array
    {
        return $this->degaine;
    }

    public function setDegaine(array $degaine): self
    {
        $this->degaine = $degaine;

        return $this;
    }

    public function getSexualite(): ?array
    {
        return $this->sexualite;
    }

    public function setSexualite(array $sexualite): self
    {
        $this->sexualite = $sexualite;

        return $this;
    }

   

    public function getStyleDeCheveux(): ?array
    {
        return $this->style_de_cheveux;
    }

    public function setStyleDeCheveux(array $style_de_cheveux): self
    {
        $this->style_de_cheveux = $style_de_cheveux;

        return $this;
    }

    public function getSilouhette(): ?array
    {
        return $this->silouhette;
    }

    public function setSilouhette(array $silouhette): self
    {
        $this->silouhette = $silouhette;

        return $this;
    }

    public function getJAiUnFaiblePour(): ?array
    {
        return $this->j_ai_un_faible_pour;
    }

    public function setJAiUnFaiblePour(array $j_ai_un_faible_pour): self
    {
        $this->j_ai_un_faible_pour = $j_ai_un_faible_pour;

        return $this;
    }

    public function getPoids(): ?int
    {
        return $this->poids;
    }

    public function setPoids(int $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    public function getCouleurDesYeux(): ?string
    {
        return $this->couleur_des_yeux;
    }

    public function setCouleurDesYeux(string $couleur_des_yeux): self
    {
        $this->couleur_des_yeux = $couleur_des_yeux;

        return $this;
    }

    public function getOrigines(): ?array
    {
        return $this->origines;
    }

    public function setOrigines(array $origines): self
    {
        $this->origines = $origines;

        return $this;
    }

    public function getJAimePorterOuPas(): ?array
    {
        return $this->j_aime_porter_ou_pas;
    }

    public function setJAimePorterOuPas(array $j_aime_porter_ou_pas): self
    {
        $this->j_aime_porter_ou_pas = $j_aime_porter_ou_pas;

        return $this;
    }

    public function getJeFrissonePour(): ?array
    {
        return $this->je_frissone_pour;
    }

    public function setJeFrissonePour(array $je_frissone_pour): self
    {
        $this->je_frissone_pour = $je_frissone_pour;

        return $this;
    }

    public function getPassionsAuLit(): ?string
    {
        return $this->passions_au_lit;
    }

    public function setPassionsAuLit(string $passions_au_lit): self
    {
        $this->passions_au_lit = $passions_au_lit;

        return $this;
    }

    public function getProffessions(): ?array
    {
        return $this->proffessions;
    }

    public function setProffessions(array $proffessions): self
    {
        $this->proffessions = $proffessions;

        return $this;
    }

    public function getSports(): ?array
    {
        return $this->sports;
    }

    public function setSports(array $sports): self
    {
        $this->sports = $sports;

        return $this;
    }

    public function getHobbies(): ?array
    {
        return $this->hobbies;
    }

    public function setHobbies(array $hobbies): self
    {
        $this->hobbies = $hobbies;

        return $this;
    }

    public function getAlcool(): ?array
    {
        return $this->alcool;
    }

    public function setAlcool(array $alcool): self
    {
        $this->alcool = $alcool;

        return $this;
    }

    public function getTabac(): ?array
    {
        return $this->tabac;
    }

    public function setTabac(array $tabac): self
    {
        $this->tabac = $tabac;

        return $this;
    }

    public function getAlimentation(): ?array
    {
        return $this->alimentation;
    }

    public function setAlimentation(array $alimentation): self
    {
        $this->alimentation = $alimentation;

        return $this;
    }

    public function getJAimeManger(): ?array
    {
        return $this->j_aime_manger;
    }

    public function setJAimeManger(array $j_aime_manger): self
    {
        $this->j_aime_manger = $j_aime_manger;

        return $this;
    }

    public function getScolarite(): ?array
    {
        return $this->scolarite;
    }

    public function setScolarite(array $scolarite): self
    {
        $this->scolarite = $scolarite;

        return $this;
    }

    public function getLangues(): ?array
    {
        return $this->langues;
    }

    public function setLangues(array $langues): self
    {
        $this->langues = $langues;

        return $this;
    }

    public function getSigneAstrologique(): ?array
    {
        return $this->signe_astrologique;
    }

    public function setSigneAstrologique(array $signe_astrologique): self
    {
        $this->signe_astrologique = $signe_astrologique;

        return $this;
    }

    public function getAvecOuSansEnfant(): ?bool
    {
        return $this->avec_ou_sans_enfant;
    }

    public function setAvecOuSansEnfant(bool $avec_ou_sans_enfant): self
    {
        $this->avec_ou_sans_enfant = $avec_ou_sans_enfant;

        return $this;
    }

    public function getGoutMusicaux(): ?array
    {
        return $this->gout_musicaux;
    }

    public function setGoutMusicaux(array $gout_musicaux): self
    {
        $this->gout_musicaux = $gout_musicaux;

        return $this;
    }

    public function getReligions(): ?array
    {
        return $this->religions;
    }

    public function setReligions(array $religions): self
    {
        $this->religions = $religions;

        return $this;
    }

    public function getPersonalite(): ?array
    {
        return $this->personalite;
    }

    public function setPersonalite(array $personalite): self
    {
        $this->personalite = $personalite;

        return $this;
    }

    public function getTaille(): ?int
    {
        return $this->taille;
    }

    public function setTaille(int $taille): self
    {
        $this->taille = $taille;

        return $this;
    }
}
