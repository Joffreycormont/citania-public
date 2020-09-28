<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ObjectEffectRepository")
 */
class ObjectEffect
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
    private $objectName;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ObjectCharacter", mappedBy="objectEffect")
     */
    private $ObjectCharacter;

    /**
     * @ORM\Column(type="integer")
     */
    private $lifeEffect = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $foodEffect = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $waterEffect = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $shapeEffect = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $cleanEffect = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $urineEffect = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $stoolsEffect = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $wasteEffect = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $sicknessEffect = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $looseLifeEffect;

    /**
     * @ORM\Column(type="integer")
     */
    private $looseFoodEffect;

    /**
     * @ORM\Column(type="integer")
     */
    private $looseWaterEffect;

    /**
     * @ORM\Column(type="integer")
     */
    private $looseShapeEffect;

    /**
     * @ORM\Column(type="integer")
     */
    private $looseCleanEffect;

    /**
     * @ORM\Column(type="integer")
     */
    private $looseUrineEffect;

    /**
     * @ORM\Column(type="integer")
     */
    private $looseStoolsEffect;

    /**
     * @ORM\Column(type="integer")
     */
    private $looseWasteEffect;

    /**
     * @ORM\Column(type="integer")
     */
    private $looseSicknessEffect;

    public function __construct()
    {
        $this->ObjectCharacter = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjectName(): ?string
    {
        return $this->objectName;
    }

    public function setObjectName(string $objectName): self
    {
        $this->objectName = $objectName;

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

    /**
     * @return Collection|ObjectCharacter[]
     */
    public function getObjectCharacter(): Collection
    {
        return $this->ObjectCharacter;
    }

    public function addObjectCharacter(ObjectCharacter $objectCharacter): self
    {
        if (!$this->ObjectCharacter->contains($objectCharacter)) {
            $this->ObjectCharacter[] = $objectCharacter;
            $objectCharacter->setObjectEffect($this);
        }

        return $this;
    }

    public function removeObjectCharacter(ObjectCharacter $objectCharacter): self
    {
        if ($this->ObjectCharacter->contains($objectCharacter)) {
            $this->ObjectCharacter->removeElement($objectCharacter);
            // set the owning side to null (unless already changed)
            if ($objectCharacter->getObjectEffect() === $this) {
                $objectCharacter->setObjectEffect(null);
            }
        }

        return $this;
    }

    public function getLifeEffect(): ?int
    {
        return $this->lifeEffect;
    }

    public function setLifeEffect(int $lifeEffect): self
    {
        $this->lifeEffect = $lifeEffect;

        return $this;
    }

    public function getFoodEffect(): ?int
    {
        return $this->foodEffect;
    }

    public function setFoodEffect(int $foodEffect): self
    {
        $this->foodEffect = $foodEffect;

        return $this;
    }

    public function getWaterEffect(): ?int
    {
        return $this->waterEffect;
    }

    public function setWaterEffect(int $waterEffect): self
    {
        $this->waterEffect = $waterEffect;

        return $this;
    }

    public function getShapeEffect(): ?int
    {
        return $this->shapeEffect;
    }

    public function setShapeEffect(int $shapeEffect): self
    {
        $this->shapeEffect = $shapeEffect;

        return $this;
    }

    public function getCleanEffect(): ?int
    {
        return $this->cleanEffect;
    }

    public function setCleanEffect(int $cleanEffect): self
    {
        $this->cleanEffect = $cleanEffect;

        return $this;
    }

    public function getUrineEffect(): ?int
    {
        return $this->urineEffect;
    }

    public function setUrineEffect(int $urineEffect): self
    {
        $this->urineEffect = $urineEffect;

        return $this;
    }

    public function getStoolsEffect(): ?int
    {
        return $this->stoolsEffect;
    }

    public function setStoolsEffect(int $stoolsEffect): self
    {
        $this->stoolsEffect = $stoolsEffect;

        return $this;
    }

    public function getWasteEffect(): ?int
    {
        return $this->wasteEffect;
    }

    public function setWasteEffect(int $wasteEffect): self
    {
        $this->wasteEffect = $wasteEffect;

        return $this;
    }

    public function getSicknessEffect(): ?int
    {
        return $this->sicknessEffect;
    }

    public function setSicknessEffect(int $sicknessEffect): self
    {
        $this->sicknessEffect = $sicknessEffect;

        return $this;
    }

    public function getlooseLifeEffect(): ?int
    {
        return $this->looseLifeEffect;
    }

    public function setlooseLifeEffect(int $looseLifeEffect): self
    {
        $this->looseLifeEffect = $looseLifeEffect;

        return $this;
    }

    public function getlooseFoodEffect(): ?int
    {
        return $this->looseFoodEffect;
    }

    public function setlooseFoodEffect(int $looseFoodEffect): self
    {
        $this->looseFoodEffect = $looseFoodEffect;

        return $this;
    }

    public function getlooseWaterEffect(): ?int
    {
        return $this->looseWaterEffect;
    }

    public function setlooseWaterEffect(int $looseWaterEffect): self
    {
        $this->looseWaterEffect = $looseWaterEffect;

        return $this;
    }

    public function getlooseShapeEffect(): ?int
    {
        return $this->looseShapeEffect;
    }

    public function setlooseShapeEffect(int $looseShapeEffect): self
    {
        $this->looseShapeEffect = $looseShapeEffect;

        return $this;
    }

    public function getlooseCleanEffect(): ?int
    {
        return $this->looseCleanEffect;
    }

    public function setlooseCleanEffect(int $looseCleanEffect): self
    {
        $this->looseCleanEffect = $looseCleanEffect;

        return $this;
    }

    public function getlooseUrineEffect(): ?int
    {
        return $this->looseUrineEffect;
    }

    public function setlooseUrineEffect(int $looseUrineEffect): self
    {
        $this->looseUrineEffect = $looseUrineEffect;

        return $this;
    }

    public function getlooseStoolsEffect(): ?int
    {
        return $this->looseStoolsEffect;
    }

    public function setlooseStoolsEffect(int $looseStoolsEffect): self
    {
        $this->looseStoolsEffect = $looseStoolsEffect;

        return $this;
    }

    public function getlooseWasteEffect(): ?int
    {
        return $this->looseWasteEffect;
    }

    public function setlooseWasteEffect(int $looseWasteEffect): self
    {
        $this->looseWasteEffect = $looseWasteEffect;

        return $this;
    }

    public function getlooseSicknessEffect(): ?int
    {
        return $this->looseSicknessEffect;
    }

    public function setlooseSicknessEffect(int $looseSicknessEffect): self
    {
        $this->looseSicknessEffect = $looseSicknessEffect;

        return $this;
    }
}
