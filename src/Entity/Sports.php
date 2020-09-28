<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SportsRepository")
 */
class Sports
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
    private $effectOnPhysic;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SportsEquipment", inversedBy="sports")
     */
    private $sportsEquipment;

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

    public function getEffectOnPhysic(): ?int
    {
        return $this->effectOnPhysic;
    }

    public function setEffectOnPhysic(int $effectOnPhysic): self
    {
        $this->effectOnPhysic = $effectOnPhysic;

        return $this;
    }

    public function getSportsEquipment(): ?SportsEquipment
    {
        return $this->sportsEquipment;
    }

    public function setSportsEquipment(?SportsEquipment $sportsEquipment): self
    {
        $this->sportsEquipment = $sportsEquipment;

        return $this;
    }
}
