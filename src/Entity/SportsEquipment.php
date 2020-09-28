<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SportsEquipmentRepository")
 */
class SportsEquipment
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
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $clientAmountToUnlock;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sports", mappedBy="sportsEquipment")
     */
    private $sports;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\SportsRoom", inversedBy="sportsEquipment")
     */
    private $rooms;

    public function __construct()
    {
        $this->sports = new ArrayCollection();
        $this->rooms = new ArrayCollection();
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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getClientAmountToUnlock(): ?int
    {
        return $this->clientAmountToUnlock;
    }

    public function setClientAmountToUnlock(int $clientAmountToUnlock): self
    {
        $this->clientAmountToUnlock = $clientAmountToUnlock;

        return $this;
    }

    /**
     * @return Collection|Sports[]
     */
    public function getSports(): Collection
    {
        return $this->sports;
    }

    public function addSport(Sports $sport): self
    {
        if (!$this->sports->contains($sport)) {
            $this->sports[] = $sport;
            $sport->setSportsEquipment($this);
        }

        return $this;
    }

    public function removeSport(Sports $sport): self
    {
        if ($this->sports->contains($sport)) {
            $this->sports->removeElement($sport);
            // set the owning side to null (unless already changed)
            if ($sport->getSportsEquipment() === $this) {
                $sport->setSportsEquipment(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|SportsRoom[]
     */
    public function getRooms(): Collection
    {
        return $this->rooms;
    }

    public function addRoom(SportsRoom $room): self
    {
        if (!$this->rooms->contains($room)) {
            $this->rooms[] = $room;
        }

        return $this;
    }

    public function removeRoom(SportsRoom $room): self
    {
        if ($this->rooms->contains($room)) {
            $this->rooms->removeElement($room);
        }

        return $this;
    }
}
