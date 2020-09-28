<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WasteToTakeRepository")
 */
class WasteToTake
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $weight;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Characters", mappedBy="wasteToTake")
     */
    private $characters;


    public function __construct(){
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

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

    public function getCharacters(): ?Characters
    {
        return $this->characters;
    }

    public function setCharacters(?Characters $characters): self
    {
        $this->characters = $characters;

        // set (or unset) the owning side of the relation if necessary
        $newWasteToTake = null === $characters ? null : $this;
        if ($characters->getWasteToTake() !== $newWasteToTake) {
            $characters->setWasteToTake($newWasteToTake);
        }

        return $this;
    }
}
