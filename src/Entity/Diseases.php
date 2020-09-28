<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DiseasesRepository")
 */
class Diseases
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
     * @ORM\OneToMany(targetEntity="App\Entity\DiseaseCharacter", mappedBy="disease")
     */
    private $diseaseCharacters;

    /**
     * @ORM\Column(type="integer")
     */
    private $effectOnLife;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Treatment", mappedBy="disease", cascade={"persist", "remove"})
     */
    private $treatment;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $level = "easy";

    public function __construct()
    {
        $this->diseaseCharacters = new ArrayCollection();
        $this->level = "easy";
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

    /**
     * @return Collection|DiseaseCharacter[]
     */
    public function getDiseaseCharacters(): Collection
    {
        return $this->diseaseCharacters;
    }

    public function addDiseaseCharacter(DiseaseCharacter $diseaseCharacter): self
    {
        if (!$this->diseaseCharacters->contains($diseaseCharacter)) {
            $this->diseaseCharacters[] = $diseaseCharacter;
            $diseaseCharacter->setDisease($this);
        }

        return $this;
    }

    public function removeDiseaseCharacter(DiseaseCharacter $diseaseCharacter): self
    {
        if ($this->diseaseCharacters->contains($diseaseCharacter)) {
            $this->diseaseCharacters->removeElement($diseaseCharacter);
            // set the owning side to null (unless already changed)
            if ($diseaseCharacter->getDisease() === $this) {
                $diseaseCharacter->setDisease(null);
            }
        }

        return $this;
    }

    public function getEffectOnLife(): ?int
    {
        return $this->effectOnLife;
    }

    public function setEffectOnLife(int $effectOnLife): self
    {
        $this->effectOnLife = $effectOnLife;

        return $this;
    }

    public function getTreatment(): ?Treatment
    {
        return $this->treatment;
    }

    public function setTreatment(?Treatment $treatment): self
    {
        $this->treatment = $treatment;

        // set (or unset) the owning side of the relation if necessary
        $newDisease = null === $treatment ? null : $this;
        if ($treatment->getDisease() !== $newDisease) {
            $treatment->setDisease($newDisease);
        }

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): self
    {
        $this->level = $level;

        return $this;
    }
}
