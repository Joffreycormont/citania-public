<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MedicPriceSubscriptionRepository")
 */
class MedicPriceSubscription
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Characters", inversedBy="medicPriceSubscription", cascade={"persist", "remove"})
     */
    private $doctor;

    /**
     * @ORM\Column(type="float")
     */
    private $priceConsultation;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDoctor(): ?Characters
    {
        return $this->doctor;
    }

    public function setDoctor(?Characters $doctor): self
    {
        $this->doctor = $doctor;

        return $this;
    }

    public function getPriceConsultation(): ?float
    {
        return $this->priceConsultation;
    }

    public function setPriceConsultation(float $priceConsultation): self
    {
        $this->priceConsultation = $priceConsultation;

        return $this;
    }
}
