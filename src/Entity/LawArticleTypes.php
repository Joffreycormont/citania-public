<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LawArticleTypesRepository")
 */
class LawArticleTypes
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
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LawArticles", mappedBy="articletype")
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
            $lawArticle->setArticletype($this);
        }

        return $this;
    }

    public function removeLawArticle(LawArticles $lawArticle): self
    {
        if ($this->lawArticles->contains($lawArticle)) {
            $this->lawArticles->removeElement($lawArticle);
            // set the owning side to null (unless already changed)
            if ($lawArticle->getArticletype() === $this) {
                $lawArticle->setArticletype(null);
            }
        }

        return $this;
    }
}
