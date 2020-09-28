<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TestAnswersRepository")
 */
class TestAnswers
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
    private $content;

    /**
     * @ORM\Column(type="integer")
     */
    private $isGoodAnswer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TestQuestions", inversedBy="testAnswers")
     */
    private $question;

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

    public function getIsGoodAnswer(): ?int
    {
        return $this->isGoodAnswer;
    }

    public function setIsGoodAnswer(int $isGoodAnswer): self
    {
        $this->isGoodAnswer = $isGoodAnswer;

        return $this;
    }

    public function getQuestion(): ?TestQuestions
    {
        return $this->question;
    }

    public function setQuestion(?TestQuestions $question): self
    {
        $this->question = $question;

        return $this;
    }
}
