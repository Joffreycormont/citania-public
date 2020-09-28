<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LawsRepository")
 */
class Laws
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
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
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $author_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\LawCodes", inversedBy="laws")
     */
    private $lawcode;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LawArticles", mappedBy="laws")
     */
    private $lawArticles;

    public function __construct()
    {
        $this->lawArticles = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getAuthorId(): ?int
    {
        return $this->author_id;
    }

    public function setAuthorId(int $author_id): self
    {
        $this->author_id = $author_id;

        return $this;
    }

    public function getLawcode(): ?LawCodes
    {
        return $this->lawcode;
    }

    public function setLawcode(?LawCodes $lawcode): self
    {
        $this->lawcode = $lawcode;

        return $this;
    }

    /**
     * @return Collection|LawArticles[]
     */
    public function getLawArticles(): Collection
    {
        return $this->lawArticles;
    }

    public function addLawArticle(LawArticles $lawArticle): self
    {
        if (!$this->lawArticles->contains($lawArticle)) {
            $this->lawArticles[] = $lawArticle;
            $lawArticle->setLaws($this);
        }

        return $this;
    }

    public function removeLawArticle(LawArticles $lawArticle): self
    {
        if ($this->lawArticles->contains($lawArticle)) {
            $this->lawArticles->removeElement($lawArticle);
            // set the owning side to null (unless already changed)
            if ($lawArticle->getLaws() === $this) {
                $lawArticle->setLaws(null);
            }
        }

        return $this;
    }
}
