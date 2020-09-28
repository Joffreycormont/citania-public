<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PharmacyRepository")
 */
class Pharmacy
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Characters", inversedBy="pharmacy", cascade={"persist", "remove"})
     */
    private $characters;

    /**
     * @ORM\Column(type="float")
     */
    private $money;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PharmacyTreatmentStock", mappedBy="pharmacy")
     */
    private $pharmacyTreatmentStocks;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PharmacyDemands", mappedBy="pharmacy")
     */
    private $pharmacyDemands;

    /**
     * @ORM\Column(type="integer")
     */
    private $ownerSalary;

    public function __construct()
    {
        $this->pharmacyTreatmentStocks = new ArrayCollection();
        $this->pharmacyDemands = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMoney(): ?float
    {
        return $this->money;
    }

    public function setMoney(float $money): self
    {
        $this->money = $money;

        return $this;
    }

    /**
     * @return Collection|PharmacyTreatmentStock[]
     */
    public function getPharmacyTreatmentStocks(): Collection
    {
        return $this->pharmacyTreatmentStocks;
    }

    public function addPharmacyTreatmentStock(PharmacyTreatmentStock $pharmacyTreatmentStock): self
    {
        if (!$this->pharmacyTreatmentStocks->contains($pharmacyTreatmentStock)) {
            $this->pharmacyTreatmentStocks[] = $pharmacyTreatmentStock;
            $pharmacyTreatmentStock->setPharmacy($this);
        }

        return $this;
    }

    public function removePharmacyTreatmentStock(PharmacyTreatmentStock $pharmacyTreatmentStock): self
    {
        if ($this->pharmacyTreatmentStocks->contains($pharmacyTreatmentStock)) {
            $this->pharmacyTreatmentStocks->removeElement($pharmacyTreatmentStock);
            // set the owning side to null (unless already changed)
            if ($pharmacyTreatmentStock->getPharmacy() === $this) {
                $pharmacyTreatmentStock->setPharmacy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PharmacyDemands[]
     */
    public function getPharmacyDemands(): Collection
    {
        return $this->pharmacyDemands;
    }

    public function addPharmacyDemand(PharmacyDemands $pharmacyDemand): self
    {
        if (!$this->pharmacyDemands->contains($pharmacyDemand)) {
            $this->pharmacyDemands[] = $pharmacyDemand;
            $pharmacyDemand->setPharmacy($this);
        }

        return $this;
    }

    public function removePharmacyDemand(PharmacyDemands $pharmacyDemand): self
    {
        if ($this->pharmacyDemands->contains($pharmacyDemand)) {
            $this->pharmacyDemands->removeElement($pharmacyDemand);
            // set the owning side to null (unless already changed)
            if ($pharmacyDemand->getPharmacy() === $this) {
                $pharmacyDemand->setPharmacy(null);
            }
        }

        return $this;
    }

    public function getOwnerSalary(): ?int
    {
        return $this->ownerSalary;
    }

    public function setOwnerSalary(int $ownerSalary): self
    {
        $this->ownerSalary = $ownerSalary;

        return $this;
    }
}
