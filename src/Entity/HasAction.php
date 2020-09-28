<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HasActionRepository")
 */
class HasAction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Actions", inversedBy="hasActions")
     */
    private $action;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Characters", inversedBy="hasActionsSend")
     */
    private $send;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Characters", inversedBy="hasActionsReceiver")
     */
    private $receiver;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAction(): ?Actions
    {
        return $this->action;
    }

    public function setAction(?Actions $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function getSend(): ?Characters
    {
        return $this->send;
    }

    public function setSend(?Characters $send): self
    {
        $this->send = $send;

        return $this;
    }

    public function getReceiver(): ?Characters
    {
        return $this->receiver;
    }

    public function setReceiver(?Characters $receiver): self
    {
        $this->receiver = $receiver;

        return $this;
    }

}
