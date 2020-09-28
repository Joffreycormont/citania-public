<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PatientRepository")
 */
class Patient
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
    private $haveSubscription;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Characters", inversedBy="patients")
     */
    private $patient;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Characters", inversedBy="doctorPatients")
     */
    private $doctor;

    /**
     * @ORM\Column(type="integer")
     */
    private $recallTreatmentStatus;

    /**
     * @ORM\Column(type="integer")
     */
    private $acceptedStatus;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHaveSubscription(): ?int
    {
        return $this->haveSubscription;
    }

    public function setHaveSubscription(int $haveSubscription): self
    {
        $this->haveSubscription = $haveSubscription;

        return $this;
    }

    public function getPatient(): ?Characters
    {
        return $this->patient;
    }

    public function setPatient(?Characters $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getDoctor(): ?Characters
    {
        return $this->doctor;
    }

    public function setDoctor(?Characters $doctor): self
    {
        $this->doctor = $doctor;

        return $this;
    }

    public function getRecallTreatmentStatus(): ?int
    {
        return $this->recallTreatmentStatus;
    }

    public function setRecallTreatmentStatus(int $recallTreatmentStatus): self
    {
        $this->recallTreatmentStatus = $recallTreatmentStatus;

        return $this;
    }

    public function getAcceptedStatus(): ?int
    {
        return $this->acceptedStatus;
    }

    public function setAcceptedStatus(int $acceptedStatus): self
    {
        $this->acceptedStatus = $acceptedStatus;

        return $this;
    }
}
