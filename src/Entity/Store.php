<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StoreRepository")
 */
class Store
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
    private $salesNumber;

    /**
     * @ORM\Column(type="float")
     */
    private $Ca;

    /**
     * @ORM\Column(type="float")
     */
    private $lostCa;

    /**
     * @ORM\Column(type="integer")
     */
    private $lostProduct;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\JobProductCategory", inversedBy="stores")
     */
    private $jobCategory;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Characters", inversedBy="stores")
     */
    private $characters;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductStore", mappedBy="store")
     */
    private $productStores;

    public function __construct()
    {
        $this->productStores = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSalesNumber(): ?int
    {
        return $this->salesNumber;
    }

    public function setSalesNumber(int $salesNumber): self
    {
        $this->salesNumber = $salesNumber;

        return $this;
    }

    public function getCa(): ?float
    {
        return $this->Ca;
    }

    public function setCa(float $Ca): self
    {
        $this->Ca = $Ca;

        return $this;
    }

    public function getLostCa(): ?float
    {
        return $this->lostCa;
    }

    public function setLostCa(float $lostCa): self
    {
        $this->lostCa = $lostCa;

        return $this;
    }

    public function getLostProduct(): ?int
    {
        return $this->lostProduct;
    }

    public function setLostProduct(int $lostProduct): self
    {
        $this->lostProduct = $lostProduct;

        return $this;
    }

    public function getJobCategory(): ?jobProductCategory
    {
        return $this->jobCategory;
    }

    public function setJobCategory(?jobProductCategory $jobCategory): self
    {
        $this->jobCategory = $jobCategory;

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

    /**
     * @return Collection|ProductStore[]
     */
    public function getProductStores(): Collection
    {
        return $this->productStores;
    }

    public function addProductStore(ProductStore $productStore): self
    {
        if (!$this->productStores->contains($productStore)) {
            $this->productStores[] = $productStore;
            $productStore->setStore($this);
        }

        return $this;
    }

    public function removeProductStore(ProductStore $productStore): self
    {
        if ($this->productStores->contains($productStore)) {
            $this->productStores->removeElement($productStore);
            // set the owning side to null (unless already changed)
            if ($productStore->getStore() === $this) {
                $productStore->setStore(null);
            }
        }

        return $this;
    }
}
