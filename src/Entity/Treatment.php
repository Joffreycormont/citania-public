<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TreatmentRepository")
 */
class Treatment
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
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Diseases", inversedBy="treatment", cascade={"persist", "remove"})
     */
    private $disease;

    /**
     * @ORM\Column(type="integer")
     */
    private $providerPrice;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PharmacyTreatmentStock", mappedBy="treatment")
     */
    private $pharmacyTreatmentStocks;

    public function __toString()
    {
        return $this->name;    
    }

    public function __construct()
    {
        $this->pharmacyTreatmentStocks = new ArrayCollection();
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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

    public function getDisease(): ?Diseases
    {
        return $this->disease;
    }

    public function setDisease(?Diseases $disease): self
    {
        $this->disease = $disease;

        return $this;
    }

    public function getProviderPrice(): ?int
    {
        return $this->providerPrice;
    }

    public function setProviderPrice(int $providerPrice): self
    {
        $this->providerPrice = $providerPrice;

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
            $pharmacyTreatmentStock->setTreatment($this);
        }

        return $this;
    }

    public function removePharmacyTreatmentStock(PharmacyTreatmentStock $pharmacyTreatmentStock): self
    {
        if ($this->pharmacyTreatmentStocks->contains($pharmacyTreatmentStock)) {
            $this->pharmacyTreatmentStocks->removeElement($pharmacyTreatmentStock);
            // set the owning side to null (unless already changed)
            if ($pharmacyTreatmentStock->getTreatment() === $this) {
                $pharmacyTreatmentStock->setTreatment(null);
            }
        }

        return $this;
    }
}
