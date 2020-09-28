<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
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
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProductStore", mappedBy="product")
     */
    private $productStores;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\JobProductCategory", inversedBy="products")
     */
    private $jobCategory;

    public function __construct()
    {
        $this->productStores = new ArrayCollection();
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
            $productStore->setProduct($this);
        }

        return $this;
    }

    public function removeProductStore(ProductStore $productStore): self
    {
        if ($this->productStores->contains($productStore)) {
            $this->productStores->removeElement($productStore);
            // set the owning side to null (unless already changed)
            if ($productStore->getProduct() === $this) {
                $productStore->setProduct(null);
            }
        }

        return $this;
    }

    public function getJobCategory(): ?JobProductCategory
    {
        return $this->jobCategory;
    }

    public function setJobCategory(?JobProductCategory $jobCategory): self
    {
        $this->jobCategory = $jobCategory;

        return $this;
    }

}
