<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TestQuestionsRepository")
 */
class TestQuestions
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\StudiesTest", inversedBy="testQuestions")
     */
    private $test;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TestAnswers", mappedBy="question")
     */
    private $testAnswers;

    /**
     * @ORM\Column(type="integer")
     */
    private $hasMultipleGoodAnwsers;

    public function __construct()
    {
        $this->testAnswers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
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

    public function getTest(): ?StudiesTest
    {
        return $this->test;
    }

    public function setTest(?StudiesTest $test): self
    {
        $this->test = $test;

        return $this;
    }

    /**
     * @return Collection|TestAnswers[]
     */
    public function getTestAnswers(): Collection
    {
        return $this->testAnswers;
    }

    public function addTestAnswer(TestAnswers $testAnswer): self
    {
        if (!$this->testAnswers->contains($testAnswer)) {
            $this->testAnswers[] = $testAnswer;
            $testAnswer->setQuestion($this);
        }

        return $this;
    }

    public function removeTestAnswer(TestAnswers $testAnswer): self
    {
        if ($this->testAnswers->contains($testAnswer)) {
            $this->testAnswers->removeElement($testAnswer);
            // set the owning side to null (unless already changed)
            if ($testAnswer->getQuestion() === $this) {
                $testAnswer->setQuestion(null);
            }
        }

        return $this;
    }

    public function getHasMultipleGoodAnwsers(): ?int
    {
        return $this->hasMultipleGoodAnwsers;
    }

    public function setHasMultipleGoodAnwsers(int $hasMultipleGoodAnwsers): self
    {
        $this->hasMultipleGoodAnwsers = $hasMultipleGoodAnwsers;

        return $this;
    }
}
