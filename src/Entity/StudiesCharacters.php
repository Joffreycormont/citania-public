<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudiesCharactersRepository")
 */
class StudiesCharacters
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
    private $durationStatus;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Studies", inversedBy="studiesCharacters")
     */
    private $study;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Characters", inversedBy="studies")
     */
    private $Characters;

    /**
     * @ORM\Column(type="integer")
     */
    private $isVip = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $yearStatus;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDurationStatus(): ?int
    {
        return $this->durationStatus;
    }

    public function setDurationStatus(int $durationStatus): self
    {
        $this->durationStatus = $durationStatus;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getStudy(): ?Studies
    {
        return $this->study;
    }

    public function setStudy(?Studies $study): self
    {
        $this->study = $study;

        return $this;
    }

    public function getCharacters(): ?Characters
    {
        return $this->Characters;
    }

    public function setCharacters(?Characters $Characters): self
    {
        $this->Characters = $Characters;

        return $this;
    }

    public function getIsVip(): ?int
    {
        return $this->isVip;
    }

    public function setIsVip(int $isVip): self
    {
        $this->isVip = $isVip;

        return $this;
    }

    public function getYearStatus(): ?int
    {
        return $this->yearStatus;
    }

    public function setYearStatus(int $yearStatus): self
    {
        $this->yearStatus = $yearStatus;

        return $this;
    }
}
