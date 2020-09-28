<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DiseaseCharacterRepository")
 */
class DiseaseCharacter
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Diseases", inversedBy="diseaseCharacters")
     */
    private $disease;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Characters", inversedBy="diseaseCharacters")
     */
    private $characters;

    /**
     * @ORM\Column(type="integer")
     */
    private $diseaseDiscoverStatus;

    function __toString()
    {
        return $this->diseaseDiscoverStatus;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCharacters(): ?Characters
    {
        return $this->characters;
    }

    public function setCharacters(?Characters $characters): self
    {
        $this->characters = $characters;

        return $this;
    }

    public function getDiseaseDiscoverStatus(): ?int
    {
        return $this->diseaseDiscoverStatus;
    }

    public function setDiseaseDiscoverStatus(int $diseaseDiscoverStatus): self
    {
        $this->diseaseDiscoverStatus = $diseaseDiscoverStatus;

        return $this;
    }
}
