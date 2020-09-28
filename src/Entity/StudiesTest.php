<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudiesTestRepository")
 */
class StudiesTest
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Studies", inversedBy="studiesTests")
     */
    private $study;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TestQuestions", mappedBy="test")
     */
    private $testQuestions;

    public function __construct()
    {
        $this->testQuestions = new ArrayCollection();
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

    public function getStudy(): ?Studies
    {
        return $this->study;
    }

    public function setStudy(?Studies $study): self
    {
        $this->study = $study;

        return $this;
    }

    /**
     * @return Collection|TestQuestions[]
     */
    public function getTestQuestions(): Collection
    {
        return $this->testQuestions;
    }

    public function addTestQuestion(TestQuestions $testQuestion): self
    {
        if (!$this->testQuestions->contains($testQuestion)) {
            $this->testQuestions[] = $testQuestion;
            $testQuestion->setTest($this);
        }

        return $this;
    }

    public function removeTestQuestion(TestQuestions $testQuestion): self
    {
        if ($this->testQuestions->contains($testQuestion)) {
            $this->testQuestions->removeElement($testQuestion);
            // set the owning side to null (unless already changed)
            if ($testQuestion->getTest() === $this) {
                $testQuestion->setTest(null);
            }
        }

        return $this;
    }
}
