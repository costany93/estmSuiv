<?php

namespace App\Entity;

use App\Repository\EtudiantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtudiantRepository::class)
 */
class Etudiant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    private $fistname;

    private $lastname;

    private $sexe;

    private $dateNaiss;

    private $email;

    private $phone;

    private $hashPassword;
    /**
     * @ORM\ManyToOne(targetEntity=Filiere::class, inversedBy="etudiants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $filiere;

    /**
     * @ORM\ManyToOne(targetEntity=Classe::class, inversedBy="etudiants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $classe;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="etudiant", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $personne;



    /**
     * @ORM\OneToMany(targetEntity=Discussion::class, mappedBy="etudiant", orphanRemoval=true)
     */
    private $discussions;

    /**
     * @ORM\ManyToOne(targetEntity=Club::class, inversedBy="etudiants")
     */
    private $club;

    /**
     * @ORM\OneToOne(targetEntity=President::class, mappedBy="etudiant", cascade={"persist", "remove"})
     */
    private $president;

    /**
     * @ORM\OneToMany(targetEntity=Answer::class, mappedBy="etudiant", orphanRemoval=true)
     */
    private $answers;

    /**
     * @ORM\OneToOne(targetEntity=Membership::class, mappedBy="etudiant", cascade={"persist", "remove"})
     */
    private $membership;

    /**
     * @ORM\OneToMany(targetEntity=Participation::class, mappedBy="etudiant", orphanRemoval=true)
     */
    private $participations;





    public function __construct()
    {
        $this->discussions = new ArrayCollection();
        $this->answers = new ArrayCollection();
        $this->participations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFistname(): ?string
    {
        return $this->fistname;
    }

    public function setFistname(string $fistname): self
    {
        $this->fistname = $fistname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getDateNaiss(): ?\DateTimeInterface
    {
        return $this->dateNaiss;
    }

    public function setDateNaiss(\DateTimeInterface $dateNaiss): self
    {
        $this->dateNaiss = $dateNaiss;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getHashPassword(): ?string
    {
        return $this->hashPassword;
    }

    public function setHashPassword(string $hashPassword): self
    {
        $this->hashPassword = $hashPassword;

        return $this;
    }
    public function getFiliere(): ?Filiere
    {
        return $this->filiere;
    }

    public function setFiliere(?Filiere $filiere): self
    {
        $this->filiere = $filiere;

        return $this;
    }

    public function getClasse(): ?Classe
    {
        return $this->classe;
    }

    public function setClasse(?Classe $classe): self
    {
        $this->classe = $classe;

        return $this;
    }

    public function getPersonne(): ?User
    {
        return $this->personne;
    }

    public function setPersonne(User $personne): self
    {
        $this->personne = $personne;

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
            $discussion->setEtudiant($this);
        }

        return $this;
    }

    public function removeDiscussion(Discussion $discussion): self
    {
        if ($this->discussions->removeElement($discussion)) {
            // set the owning side to null (unless already changed)
            if ($discussion->getEtudiant() === $this) {
                $discussion->setEtudiant(null);
            }
        }

        return $this;
    }

    public function getClub(): ?Club
    {
        return $this->club;
    }

    public function setClub(?Club $club): self
    {
        $this->club = $club;

        return $this;
    }

    public function getPresident(): ?President
    {
        return $this->president;
    }

    public function setPresident(President $president): self
    {
        // set the owning side of the relation if necessary
        if ($president->getEtudiant() !== $this) {
            $president->setEtudiant($this);
        }

        $this->president = $president;

        return $this;
    }

    /**
     * @return Collection|Answer[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setEtudiant($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getEtudiant() === $this) {
                $answer->setEtudiant(null);
            }
        }

        return $this;
    }

    public function getMembership(): ?Membership
    {
        return $this->membership;
    }

    public function setMembership(Membership $membership): self
    {
        // set the owning side of the relation if necessary
        if ($membership->getEtudiant() !== $this) {
            $membership->setEtudiant($this);
        }

        $this->membership = $membership;

        return $this;
    }

    /**
     * @return Collection|Participation[]
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipation(Participation $participation): self
    {
        if (!$this->participations->contains($participation)) {
            $this->participations[] = $participation;
            $participation->setEtudiant($this);
        }

        return $this;
    }

    public function removeParticipation(Participation $participation): self
    {
        if ($this->participations->removeElement($participation)) {
            // set the owning side to null (unless already changed)
            if ($participation->getEtudiant() === $this) {
                $participation->setEtudiant(null);
            }
        }

        return $this;
    }

    

}
