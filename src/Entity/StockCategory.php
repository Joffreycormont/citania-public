<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StockCategoryRepository")
 */
class StockCategory
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
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ObjectCharacter", mappedBy="stockCategory")
     */
    private $objectCharacters;

    public function __construct()
    {
        $this->objectCharacters = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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
     * @return Collection|ObjectCharacter[]
     */
    public function getObjectCharacters(): Collection
    {
        return $this->objectCharacters;
    }

    public function addObjectCharacter(ObjectCharacter $objectCharacter): self
    {
        if (!$this->objectCharacters->contains($objectCharacter)) {
            $this->objectCharacters[] = $objectCharacter;
            $objectCharacter->setStockCategory($this);
        }

        return $this;
    }

    public function removeObjectCharacter(ObjectCharacter $objectCharacter): self
    {
        if ($this->objectCharacters->contains($objectCharacter)) {
            $this->objectCharacters->removeElement($objectCharacter);
            // set the owning side to null (unless already changed)
            if ($objectCharacter->getStockCategory() === $this) {
                $objectCharacter->setStockCategory(null);
            }
        }

        return $this;
    }
}
