<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ElectionCandidatesRepository")
 */
class ElectionCandidates
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
    private $voteCounter;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $candidateId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVoteCounter(): ?int
    {
        return $this->voteCounter;
    }

    public function setVoteCounter(int $voteCounter): self
    {
        $this->voteCounter = $voteCounter;

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

    public function getCandidateId(): ?int
    {
        return $this->candidateId;
    }

    public function setCandidateId(int $candidateId): self
    {
        $this->candidateId = $candidateId;

        return $this;
    }
}
