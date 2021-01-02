<?php

namespace App\Entity;

use App\Repository\InformationRepository;
use Cocur\Slugify\Slugify;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InformationRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class Information
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
     * @ORM\Column(type="string", length=255)
     */
    private $coverImage;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity=Club::class, inversedBy="informations�")
     */
    private $club;

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

    public function getCoverImage(): ?string
    {
        return $this->coverImage;
    }

    public function setCoverImage(string $coverImage): self
    {
        $this->coverImage = $coverImage;

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

    public function getClub(): ?Club
    {
        return $this->club;
    }

    public function setClub(?Club $club): self
    {
        $this->club = $club;

        return $this;
    }
}
