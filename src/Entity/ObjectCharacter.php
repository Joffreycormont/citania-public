<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ObjectCharacterRepository")
 */
class ObjectCharacter
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
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\StockCategory", inversedBy="objectCharacters")
     */
    private $stockCategory;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Characters", inversedBy="objectCharacters")
     */
    private $characters;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ObjectEffect", inversedBy="ObjectCharacter")
     */
    private $objectEffect;

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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

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

    public function getStockCategory(): ?stockCategory
    {
        return $this->stockCategory;
    }

    public function setStockCategory(?stockCategory $stockCategory): self
    {
        $this->stockCategory = $stockCategory;

        return $this;
    }

    public function getCharacters(): ?Characters
    {
        return $this->characters;
    }

    public function setCharacters(?Characters $characters): self
    {
        $this->characters = $characters;

        return $this;
    }

    public function getObjectEffect(): ?ObjectEffect
    {
        return $this->objectEffect;
    }

    public function setObjectEffect(?ObjectEffect $objectEffect): self
    {
        $this->objectEffect = $objectEffect;

        return $this;
    }
}
