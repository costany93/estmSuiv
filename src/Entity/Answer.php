<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnswerRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Answer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Discussion::class, inversedBy="answers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $discussion;

    /**
     * @ORM\ManyToOne(targetEntity=Etudiant::class, inversedBy="answers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $etudiant;
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

    public function getDiscussion(): ?Discussion
    {
        return $this->discussion;
    }

    public function setDiscussion(?Discussion $discussion): self
    {
        $this->discussion = $discussion;

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
}
