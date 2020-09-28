<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="integer")
     */
    private $status = 0;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $UpdatedAt;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Characters", inversedBy="user", cascade={"persist", "remove"})
     */
    private $characters;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $isConnected;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $rulesAccepted;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommandPremium", mappedBy="user")
     */
    private $commandPrem;


    public function __construct(){
        $this->createdAt = new \DateTime;
        $this->commandPrem = new ArrayCollection();

    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $UpdatedAt): self
    {
        $this->UpdatedAt = $UpdatedAt;

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

    public function getIsConnected(): ?int
    {
        return $this->isConnected;
    }

    public function setIsConnected(int $isConnected): self
    {
        $this->isConnected = $isConnected;

        return $this;
    }

    public function getRulesAccepted(): ?int
    {
        return $this->rulesAccepted;
    }

    public function setRulesAccepted(int $rulesAccepted): self
    {
        $this->rulesAccepted = $rulesAccepted;

        return $this;
    }

    /**
     * @return Collection|CommandPremium[]
     */
    public function getCommandPrem(): Collection
    {
        return $this->commandPrem;
    }

    public function addCommandPrem(CommandPremium $commandPrem): self
    {
        if (!$this->commandPrem->contains($commandPrem)) {
            $this->commandPrem[] = $commandPrem;
            $commandPrem->setUser($this);
        }

        return $this;
    }

    public function removeCommandPrem(CommandPremium $commandPrem): self
    {
        if ($this->commandPrem->contains($commandPrem)) {
            $this->commandPrem->removeElement($commandPrem);
            // set the owning side to null (unless already changed)
            if ($commandPrem->getUser() === $this) {
                $commandPrem->setUser(null);
            }
        }

        return $this;
    }
}
