<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SportsRoomRepository")
 */
class SportsRoom
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
    private $priceSub;

    /**
     * @ORM\Column(type="integer")
     */
    private $priceConsult;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Characters", inversedBy="sportsRoom", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $coach;

    /**
     * @ORM\Column(type="integer")
     */
    private $clientAmount;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\SportsEquipment", mappedBy="rooms")
     */
    private $sportsEquipment;

    public function __construct()
    {
        $this->sportsEquipment = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPriceSub(): ?int
    {
        return $this->priceSub;
    }

    public function setPriceSub(int $priceSub): self
    {
        $this->priceSub = $priceSub;

        return $this;
    }

    public function getPriceConsult(): ?int
    {
        return $this->priceConsult;
    }

    public function setPriceConsult(int $priceConsult): self
    {
        $this->priceConsult = $priceConsult;

        return $this;
    }

    public function getCoach(): ?Characters
    {
        return $this->coach;
    }

    public function setCoach(Characters $coach): self
    {
        $this->coach = $coach;

        return $this;
    }

    public function getClientAmount(): ?int
    {
        return $this->clientAmount;
    }

    public function setClientAmount(int $clientAmount): self
    {
        $this->clientAmount = $clientAmount;

        return $this;
    }

    /**
     * @return Collection|SportsEquipment[]
     */
    public function getSportsEquipment(): Collection
    {
        return $this->sportsEquipment;
    }

    public function addSportsEquipment(SportsEquipment $sportsEquipment): self
    {
        if (!$this->sportsEquipment->contains($sportsEquipment)) {
            $this->sportsEquipment[] = $sportsEquipment;
            $sportsEquipment->addRoom($this);
        }

        return $this;
    }

    public function removeSportsEquipment(SportsEquipment $sportsEquipment): self
    {
        if ($this->sportsEquipment->contains($sportsEquipment)) {
            $this->sportsEquipment->removeElement($sportsEquipment);
            $sportsEquipment->removeRoom($this);
        }

        return $this;
    }
}
