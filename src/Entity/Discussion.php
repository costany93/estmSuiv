<?php

namespace App\Entity;

use App\Repository\DiscussionRepository;
use Cocur\Slugify\Slugify;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DiscussionRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Discussion
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Club::class, inversedBy="discussions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $club;

    /**
     * @ORM\ManyToOne(targetEntity=Etudiant::class, inversedBy="discussions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etudiant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=Answer::class, mappedBy="discussion", orphanRemoval=true)
     */
    private $answers;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
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
            $this->slug = $slugify->slugify('club '.$this->title);
        }
    }
    /**
     * permet d'initilaiser notre date de création
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
            return $this;
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getClub(): ?Club
    {
        return $this->club;
    }

    public function setClub(?Club $club): self
    {
        $this->club = $club;

        return $this;
    }

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): self
    {
        $this->etudiant = $etudiant;

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
            $answer->setDiscussion($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->removeElement($answer)) {
            // set the owning side to null (unless already changed)
            if ($answer->getDiscussion() === $this) {
                $answer->setDiscussion(null);
            }
        }

        return $this;
    }
}
