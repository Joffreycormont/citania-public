<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudiesRepository")
 */
class Studies
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $duration;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StudiesCharacters", mappedBy="study")
     */
    private $studiesCharacters;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="integer")
     */
    private $priceDiamond;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Jobs", mappedBy="studies")
     */
    private $job;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $othersStudiesRequired;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StudiesTest", mappedBy="study")
     */
    private $studiesTests;

    public function __construct()
    {
        $this->studiesCharacters = new ArrayCollection();
        $this->job = new ArrayCollection();
        $this->studiesTests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
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

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return Collection|StudiesCharacters[]
     */
    public function getStudiesCharacters(): Collection
    {
        return $this->studiesCharacters;
    }

    public function addStudiesCharacter(StudiesCharacters $studiesCharacter): self
    {
        if (!$this->studiesCharacters->contains($studiesCharacter)) {
            $this->studiesCharacters[] = $studiesCharacter;
            $studiesCharacter->setStudy($this);
        }

        return $this;
    }

    public function removeStudiesCharacter(StudiesCharacters $studiesCharacter): self
    {
        if ($this->studiesCharacters->contains($studiesCharacter)) {
            $this->studiesCharacters->removeElement($studiesCharacter);
            // set the owning side to null (unless already changed)
            if ($studiesCharacter->getStudy() === $this) {
                $studiesCharacter->setStudy(null);
            }
        }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getPriceDiamond(): ?int
    {
        return $this->priceDiamond;
    }

    public function setPriceDiamond(int $priceDiamond): self
    {
        $this->priceDiamond = $priceDiamond;

        return $this;
    }

    /**
     * @return Collection|Jobs[]
     */
    public function getJob(): Collection
    {
        return $this->job;
    }

    public function addJob(Jobs $job): self
    {
        if (!$this->job->contains($job)) {
            $this->job[] = $job;
            $job->setStudies($this);
        }

        return $this;
    }

    public function removeJob(Jobs $job): self
    {
        if ($this->job->contains($job)) {
            $this->job->removeElement($job);
            // set the owning side to null (unless already changed)
            if ($job->getStudies() === $this) {
                $job->setStudies(null);
            }
        }

        return $this;
    }

    public function getOthersStudiesRequired(): ?string
    {
        return $this->othersStudiesRequired;
    }

    public function setOthersStudiesRequired(string $othersStudiesRequired): self
    {
        $this->othersStudiesRequired = $othersStudiesRequired;

        return $this;
    }

    /**
     * @return Collection|StudiesTest[]
     */
    public function getStudiesTests(): Collection
    {
        return $this->studiesTests;
    }

    public function addStudiesTest(StudiesTest $studiesTest): self
    {
        if (!$this->studiesTests->contains($studiesTest)) {
            $this->studiesTests[] = $studiesTest;
            $studiesTest->setStudy($this);
        }

        return $this;
    }

    public function removeStudiesTest(StudiesTest $studiesTest): self
    {
        if ($this->studiesTests->contains($studiesTest)) {
            $this->studiesTests->removeElement($studiesTest);
            // set the owning side to null (unless already changed)
            if ($studiesTest->getStudy() === $this) {
                $studiesTest->setStudy(null);
            }
        }

        return $this;
    }
}
