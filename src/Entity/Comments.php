<?php

namespace App\Entity;

use DateInterval;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentsRepository")
 */
class Comments
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
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Characters", inversedBy="comments")
     */
    private $characters;

    /**
     * @ORM\Column(type="integer")
     */
    private $sendId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sendName;

    /**
     * @ORM\Column(type="integer")
     */
    private $status = 0;

    public function __construct(){

        $this->createdAt = new \DateTime();
    }


    public function __toString()
    {
        return $this->content;
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

    public function getCharacters(): ?Characters
    {
        return $this->characters;
    }

    public function setCharacters(?Characters $characters): self
    {
        $this->characters = $characters;

        return $this;
    }

    public function getSendId(): ?int
    {
        return $this->sendId;
    }

    public function setSendId(int $sendId): self
    {
        $this->sendId = $sendId;

        return $this;
    }

    public function getSendName(): ?string
    {
        return $this->sendName;
    }

    public function setSendName(string $sendName): self
    {
        $this->sendName = $sendName;

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

}
