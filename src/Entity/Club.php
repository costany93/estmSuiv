<?php

namespace App\Entity;

use App\Repository\ClubRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Cocur\Slugify\Slugify;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClubRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Club
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
    private $nom;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $coverImage;

    /**
     * @ORM\Column(type="text")
     */
    private $description;



    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=Information::class, mappedBy="club")
     */
    private $informations;

    /**
     * @ORM\OneToMany(targetEntity=Discussion::class, mappedBy="club", orphanRemoval=true)
     */
    private $discussions;

    /**
     * @ORM\OneToMany(targetEntity=Etudiant::class, mappedBy="club")
     */
    private $etudiants;

    /**
     * @ORM\OneToOne(targetEntity=President::class, mappedBy="club", cascade={"persist", "remove"})
     */
    private $president;

    /**
     * @ORM\OneToMany(targetEntity=Membership::class, mappedBy="club", orphanRemoval=true)
     */
    private $memberships;

    /**
     * @ORM\OneToMany(targetEntity=Activity::class, mappedBy="club")
     */
    private $activities;




    public function __construct()
    {
        $this->informations = new ArrayCollection();
        $this->discussions = new ArrayCollection();
        $this->etudiants = new ArrayCollection();
        $this->memberships = new ArrayCollection();
        $this->activities = new ArrayCollection();
    }


    /**
     * permet d'initialiser notre notre date de 
     * 
     * permet de dire à notre manager de toujours éxécuter cette fonction
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * 
     * @return void
     */
    public function initializeCreatedAt(){
        if(empty($this->createdAt)){
            $this->createdAt = new DateTime();
        }
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * permet d'initilaiser notre slug
     * 
     * permet de dire à notre manager de toujours éxécuter cette fonction
     * @ORM\PrePersist
     * @ORM\PreUpdate
     * 
     * @return void
     */
    public function initializeSlug(){
        if(empty($this->slug)){
            $slugify = new Slugify();
            $this->slug = $slugify->slugify('club '.$this->nom);
        }
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(string $coverImage): self
    {
        $this->coverImage = $coverImage;

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

    
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|Information[]
     */
    public function getInformations(): Collection
    {
        return $this->informations;
    }

    public function addInformations(Information $informations): self
    {
        if (!$this->informations->contains($informations)) {
            $this->informations[] = $informations;
            $informations->setClub($this);
        }

        return $this;
    }

    public function removeInformations(Information $informations): self
    {
        if ($this->informations->removeElement($informations)) {
            // set the owning side to null (unless already changed)
            if ($informations->getClub() === $this) {
                $informations->setClub(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Discussion[]
     */
    public function getDiscussions(): Collection
    {
        return $this->discussions;
    }

    public function addDiscussion(Discussion $discussion): self
    {
        if (!$this->discussions->contains($discussion)) {
            $this->discussions[] = $discussion;
            $discussion->setClub($this);
        }

        return $this;
    }

    public function removeDiscussion(Discussion $discussion): self
    {
        if ($this->discussions->removeElement($discussion)) {
            // set the owning side to null (unless already changed)
            if ($discussion->getClub() === $this) {
                $discussion->setClub(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Etudiant[]
     */
    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function addEtudiant(Etudiant $etudiant): self
    {
        if (!$this->etudiants->contains($etudiant)) {
            $this->etudiants[] = $etudiant;
            $etudiant->setClub($this);
        }

        return $this;
    }

    public function removeEtudiant(Etudiant $etudiant): self
    {
        if ($this->etudiants->removeElement($etudiant)) {
            // set the owning side to null (unless already changed)
            if ($etudiant->getClub() === $this) {
                $etudiant->setClub(null);
            }
        }

        return $this;
    }

    public function getPresident(): ?President
    {
        return $this->president;
    }

    public function setPresident(President $president): self
    {
        // set the owning side of the relation if necessary
        if ($president->getClub() !== $this) {
            $president->setClub($this);
        }

        $this->president = $president;

        return $this;
    }

    /**
     * @return Collection|Membership[]
     */
    public function getMemberships(): Collection
    {
        return $this->memberships;
    }

    public function addMembership(Membership $membership): self
    {
        if (!$this->memberships->contains($membership)) {
            $this->memberships[] = $membership;
            $membership->setClub($this);
        }

        return $this;
    }

    public function removeMembership(Membership $membership): self
    {
        if ($this->memberships->removeElement($membership)) {
            // set the owning side to null (unless already changed)
            if ($membership->getClub() === $this) {
                $membership->setClub(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Activity[]
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity(Activity $activity): self
    {
        if (!$this->activities->contains($activity)) {
            $this->activities[] = $activity;
            $activity->setClub($this);
        }

        return $this;
    }

    public function removeActivity(Activity $activity): self
    {
        if ($this->activities->removeElement($activity)) {
            // set the owning side to null (unless already changed)
            if ($activity->getClub() === $this) {
                $activity->setClub(null);
            }
        }

        return $this;
    }



   
}
