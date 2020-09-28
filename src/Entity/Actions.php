<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActionsRepository")
 */
class Actions
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
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\HasAction", mappedBy="action")
     */
    private $hasActions;

    public function __construct()
    {
        $this->hasActions = new ArrayCollection();
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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|HasAction[]
     */
    public function getHasActions(): Collection
    {
        return $this->hasActions;
    }

    public function addHasAction(HasAction $hasAction): self
    {
        if (!$this->hasActions->contains($hasAction)) {
            $this->hasActions[] = $hasAction;
            $hasAction->setAction($this);
        }

        return $this;
    }

    public function removeHasAction(HasAction $hasAction): self
    {
        if ($this->hasActions->contains($hasAction)) {
            $this->hasActions->removeElement($hasAction);
            // set the owning side to null (unless already changed)
            if ($hasAction->getAction() === $this) {
                $hasAction->setAction(null);
            }
        }

        return $this;
    }
}
