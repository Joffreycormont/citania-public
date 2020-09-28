<?php

namespace App\Entity;

use DateInterval;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CharactersRepository")
 * 
 */
class Characters
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $age = 18;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="float")
     */
    private $money = 1000;

    /**
     * @ORM\Column(type="integer")
     */
    private $diamond = 10;

    /**
     * @ORM\Column(type="smallint")
     */
    private $life = 100;

    /**
     * @ORM\Column(type="smallint")
     */
    private $food = 70;

    /**
     * @ORM\Column(type="smallint")
     */
    private $water = 50;

    /**
     * @ORM\Column(type="smallint")
     */
    private $sickness = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $shape = 100;

    /**
     * @ORM\Column(type="smallint")
     */
    private $cleanliness = 100;

    /**
     * @ORM\Column(type="smallint")
     */
    private $urine = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $stools = 0;

    /**
     * @ORM\Column(type="smallint")
     */
    private $waste = 0;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="characters", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\RelationStatus", inversedBy="characters")
     */
    private $relation_status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Jobs", inversedBy="characters")
     */
    private $job;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comments", mappedBy="characters")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Logbook", mappedBy="characters")
     */
    private $logbooks;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Profils", mappedBy="characters", cascade={"persist", "remove"})
     */
    private $profils;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sexe;

    /**
     * @ORM\Column(type="integer")
     */
    private $visitor = 0;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Humor", inversedBy="characters")
     */
    private $humor;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $die;

    /**
     * @ORM\Column(type="integer")
     */
    private $isWindowOpen = 1;

    /**
     * @ORM\Column(type="integer")
     */
    private $kisses = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $punchs = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $hugs = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $pinchs = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $smiles = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $pulledHair = 0;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Childrens", inversedBy="characters")
     */
    private $childrens;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Messages", mappedBy="send")
     */
    private $messagesSend;

    /**
     * @ORM\Column(type="integer")
     */
    private $stamps = 25;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Advertising", mappedBy="characters")
     */
    private $advertisings;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FriendRequests", mappedBy="send")
     */
    private $friendRequestsSend;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FriendRequests", mappedBy="receiver")
     */
    private $friendRequestsReceiver;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\HasAction", mappedBy="send")
     */
    private $hasActionsSend;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\HasAction", mappedBy="receiver")
     */
    private $hasActionsReceiver;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Logbook", mappedBy="send")
     */
    private $logbooksSend;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\WasteToTake", inversedBy="characters")
     */
    private $wasteToTake;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\TruckWaste", mappedBy="characters", cascade={"persist", "remove"})
     */
    private $truckWaste;

    /**
     * @ORM\Column(type="text")
     */
    private $jobPresentation = "";

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ObjectCharacter", mappedBy="characters")
     */
    private $objectCharacters;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Store", mappedBy="characters")
     */
    private $stores;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\House", inversedBy="characters")
     */
    private $house;

    /**
     * @ORM\Column(type="integer")
     */
    private $houseProperty;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\HouseFurniture", mappedBy="characters")
     */
    private $houseFurniture;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\StudiesCharacters", mappedBy="Characters")
     */
    private $studies;

    /**
     * @ORM\Column(type="integer")
     */
    private $newsReaded = 0;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DiseaseCharacter", mappedBy="characters")
     */
    private $diseaseCharacters;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Patient", mappedBy="patient")
     */
    private $patients;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Patient", mappedBy="doctor")
     */
    private $doctorPatients;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\MedicPriceSubscription", mappedBy="doctor", cascade={"persist", "remove"})
     */
    private $medicPriceSubscription;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $treatmentSubscription = null;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Pharmacy", mappedBy="characters", cascade={"persist", "remove"})
     */
    private $pharmacy;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\PharmacyDemands", mappedBy="characters")
     */
    private $pharmacyDemand;

    /**
     * @ORM\Column(type="integer")
     */
    private $treatmentTaken = 0;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $musicProfilLink;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\StampStock", mappedBy="characters", cascade={"persist", "remove"})
     */
    private $stampStock;

    /**
     * @ORM\Column(type="integer")
     */
    private $casinoCoins = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $casinoGamePlayed = 0;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\SportsRoom", mappedBy="coach", cascade={"persist", "remove"})
     */
    private $sportsRoom;


    public function __construct(){
        $this->createdAt = new \DateTime();
        $this->comments = new ArrayCollection();
        $this->logbooks = new ArrayCollection();
        $this->childrens = new ArrayCollection();
        $this->messagesSend = new ArrayCollection();
        $this->advertisings = new ArrayCollection();
        $this->friendRequestsSend = new ArrayCollection();
        $this->friendRequestsReceiver = new ArrayCollection();
        $this->hasActions = new ArrayCollection();
        $this->hasActionsSend = new ArrayCollection();
        $this->hasActionsReceiver = new ArrayCollection();
        $this->logbooksSend = new ArrayCollection();
        $this->objectCharacters = new ArrayCollection();
        $this->stores = new ArrayCollection();
        $this->houseFurniture = new ArrayCollection();
        $this->studies = new ArrayCollection();
        $this->diseaseCharacters = new ArrayCollection();
        $this->patients = new ArrayCollection();
        $this->doctorPatients = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getMoney(): ?float
    {
        return $this->money;
    }

    public function setMoney(float $money): self
    {
        $this->money = $money;

        return $this;
    }

    public function getDiamond(): ?int
    {
        return $this->diamond;
    }

    public function setDiamond(int $diamond): self
    {
        $this->diamond = $diamond;

        return $this;
    }

    public function getLife(): ?int
    {
        return $this->life;
    }

    public function setLife(int $life): self
    {
        $this->life = $life;

        return $this;
    }

    public function getFood(): ?int
    {
        return $this->food;
    }

    public function setFood(int $food): self
    {
        $this->food = $food;

        return $this;
    }

    public function getWater(): ?int
    {
        return $this->water;
    }

    public function setWater(int $water): self
    {
        $this->water = $water;

        return $this;
    }

    public function getSickness(): ?int
    {
        return $this->sickness;
    }

    public function setSickness(int $sickness): self
    {
        $this->sickness = $sickness;

        return $this;
    }

    public function getShape(): ?int
    {
        return $this->shape;
    }

    public function setShape(int $shape): self
    {
        $this->shape = $shape;

        return $this;
    }

    public function getCleanliness(): ?int
    {
        return $this->cleanliness;
    }

    public function setCleanliness(int $cleanliness): self
    {
        $this->cleanliness = $cleanliness;

        return $this;
    }

    public function getUrine(): ?int
    {
        return $this->urine;
    }

    public function setUrine(int $urine): self
    {
        $this->urine = $urine;

        return $this;
    }

    public function getStools(): ?int
    {
        return $this->stools;
    }

    public function setStools(int $stools): self
    {
        $this->stools = $stools;

        return $this;
    }

    public function getWaste(): ?int
    {
        return $this->waste;
    }

    public function setWaste(int $waste): self
    {
        $this->waste = $waste;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        // set (or unset) the owning side of the relation if necessary
        $newCharacters = null === $user ? null : $this;
        if ($user->getCharacters() !== $newCharacters) {
            $user->setCharacters($newCharacters);
        }

        return $this;
    }

    public function getRelationStatus(): ?RelationStatus
    {
        return $this->relation_status;
    }

    public function setRelationStatus(?RelationStatus $relation_status): self
    {
        $this->relation_status = $relation_status;

        return $this;
    }

    public function getJob(): ?Jobs
    {
        return $this->job;
    }

    public function setJob(?Jobs $job): self
    {
        $this->job = $job;

        return $this;
    }

    /**
     * @return Collection|Comments[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setCharacters($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getCharacters() === $this) {
                $comment->setCharacters(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Logbook[]
     */
    public function getLogbooks(): Collection
    {
        return $this->logbooks;
    }

    public function addLogbook(Logbook $logbook): self
    {
        if (!$this->logbooks->contains($logbook)) {
            $this->logbooks[] = $logbook;
            $logbook->setCharacters($this);
        }

        return $this;
    }

    public function removeLogbook(Logbook $logbook): self
    {
        if ($this->logbooks->contains($logbook)) {
            $this->logbooks->removeElement($logbook);
            // set the owning side to null (unless already changed)
            if ($logbook->getCharacters() === $this) {
                $logbook->setCharacters(null);
            }
        }

        return $this;
    }

    public function getProfils(): ?Profils
    {
        return $this->profils;
    }

    public function setProfils(?Profils $profils): self
    {
        $this->profils = $profils;

        // set (or unset) the owning side of the relation if necessary
        $newCharacters = null === $profils ? null : $this;
        if ($profils->getCharacters() !== $newCharacters) {
            $profils->setCharacters($newCharacters);
        }

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getVisitor(): ?int
    {
        return $this->visitor;
    }

    public function setVisitor(int $visitor): self
    {
        $this->visitor = $visitor;

        return $this;
    }

    public function getHumor(): ?Humor
    {
        return $this->humor;
    }

    public function setHumor(?Humor $humor): self
    {
        $this->humor = $humor;

        return $this;
    }

    public function getDie(): ?int
    {
        return $this->die;
    }

    public function setDie(?int $die): self
    {
        $this->die = $die;

        return $this;
    }

    public function getIsWindowOpen(): ?int
    {
        return $this->isWindowOpen;
    }

    public function setIsWindowOpen(bool $isWindowOpen): self
    {
        $this->isWindowOpen = $isWindowOpen;

        return $this;
    }

    public function getKisses(): ?int
    {
        return $this->kisses;
    }

    public function setKisses(int $kisses): self
    {
        $this->kisses = $kisses;

        return $this;
    }

    public function getPunchs(): ?int
    {
        return $this->punchs;
    }

    public function setPunchs(int $punchs): self
    {
        $this->punchs = $punchs;

        return $this;
    }

    public function getHugs(): ?int
    {
        return $this->hugs;
    }

    public function setHugs(int $hugs): self
    {
        $this->hugs = $hugs;

        return $this;
    }

    public function getPinchs(): ?int
    {
        return $this->pinchs;
    }

    public function setPinchs(int $pinchs): self
    {
        $this->pinchs = $pinchs;

        return $this;
    }

    public function getSmiles(): ?int
    {
        return $this->smiles;
    }

    public function setSmiles(int $smiles): self
    {
        $this->smiles = $smiles;

        return $this;
    }

    public function getPulledHair(): ?int
    {
        return $this->pulledHair;
    }

    public function setPulledHair(int $pulledHair): self
    {
        $this->pulledHair = $pulledHair;

        return $this;
    }

    /**
     * @return Collection|Childrens[]
     */
    public function getChildrens(): Collection
    {
        return $this->childrens;
    }

    public function addChildren(Childrens $children): self
    {
        if (!$this->childrens->contains($children)) {
            $this->childrens[] = $children;
        }

        return $this;
    }

    public function removeChildren(Childrens $children): self
    {
        if ($this->childrens->contains($children)) {
            $this->childrens->removeElement($children);
        }

        return $this;
    }

    /**
     * @return Collection|Messages[]
     */
    public function getMessagesSend(): Collection
    {
        return $this->messagesSend;
    }

    public function addMessagesSend(Messages $messagesSend): self
    {
        if (!$this->messagesSend->contains($messagesSend)) {
            $this->messagesSend[] = $messagesSend;
            $messagesSend->setSendId($this);
        }

        return $this;
    }

    public function removeMessagesSend(Messages $messagesSend): self
    {
        if ($this->messagesSend->contains($messagesSend)) {
            $this->messagesSend->removeElement($messagesSend);
            // set the owning side to null (unless already changed)
            if ($messagesSend->getSendId() === $this) {
                $messagesSend->setSendId(null);
            }
        }

        return $this;
    }

    public function getStamps(): ?int
    {
        return $this->stamps;
    }

    public function setStamps(int $stamps): self
    {
        $this->stamps = $stamps;

        return $this;
    }

    /**
     * @return Collection|Advertising[]
     */
    public function getAdvertisings(): Collection
    {
        return $this->advertisings;
    }

    public function addAdvertising(Advertising $advertising): self
    {
        if (!$this->advertisings->contains($advertising)) {
            $this->advertisings[] = $advertising;
            $advertising->setCharacters($this);
        }

        return $this;
    }

    public function removeAdvertising(Advertising $advertising): self
    {
        if ($this->advertisings->contains($advertising)) {
            $this->advertisings->removeElement($advertising);
            // set the owning side to null (unless already changed)
            if ($advertising->getCharacters() === $this) {
                $advertising->setCharacters(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FriendRequests[]
     */
    public function getFriendRequestsSend(): Collection
    {
        return $this->friendRequestsSend;
    }

    public function addFriendRequestsSend(FriendRequests $friendRequestsSend): self
    {
        if (!$this->friendRequestsSend->contains($friendRequestsSend)) {
            $this->friendRequestsSend[] = $friendRequestsSend;
            $friendRequestsSend->setSend($this);
        }

        return $this;
    }

    public function removeFriendRequestsSend(FriendRequests $friendRequestsSend): self
    {
        if ($this->friendRequestsSend->contains($friendRequestsSend)) {
            $this->friendRequestsSend->removeElement($friendRequestsSend);
            // set the owning side to null (unless already changed)
            if ($friendRequestsSend->getSend() === $this) {
                $friendRequestsSend->setSend(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FriendRequests[]
     */
    public function getFriendRequestsReceiver(): Collection
    {
        return $this->friendRequestsReceiver;
    }

    public function addFriendRequestsReceiver(FriendRequests $friendRequestsReceiver): self
    {
        if (!$this->friendRequestsReceiver->contains($friendRequestsReceiver)) {
            $this->friendRequestsReceiver[] = $friendRequestsReceiver;
            $friendRequestsReceiver->setReceiver($this);
        }

        return $this;
    }

    public function removeFriendRequestsReceiver(FriendRequests $friendRequestsReceiver): self
    {
        if ($this->friendRequestsReceiver->contains($friendRequestsReceiver)) {
            $this->friendRequestsReceiver->removeElement($friendRequestsReceiver);
            // set the owning side to null (unless already changed)
            if ($friendRequestsReceiver->getReceiver() === $this) {
                $friendRequestsReceiver->setReceiver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|HasAction[]
     */
    public function getHasActionsSend(): Collection
    {
        return $this->hasActionsSend;
    }

    public function addHasActionsSend(HasAction $hasActionsSend): self
    {
        if (!$this->hasActionsSend->contains($hasActionsSend)) {
            $this->hasActionsSend[] = $hasActionsSend;
            $hasActionsSend->setSend($this);
        }

        return $this;
    }

    public function removeHasActionsSend(HasAction $hasActionsSend): self
    {
        if ($this->hasActionsSend->contains($hasActionsSend)) {
            $this->hasActionsSend->removeElement($hasActionsSend);
            // set the owning side to null (unless already changed)
            if ($hasActionsSend->getSend() === $this) {
                $hasActionsSend->setSend(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|HasAction[]
     */
    public function getHasActionsReceiver(): Collection
    {
        return $this->hasActionsReceiver;
    }

    public function addHasActionsReceiver(HasAction $hasActionsReceiver): self
    {
        if (!$this->hasActionsReceiver->contains($hasActionsReceiver)) {
            $this->hasActionsReceiver[] = $hasActionsReceiver;
            $hasActionsReceiver->setReceiver($this);
        }

        return $this;
    }

    public function removeHasActionsReceiver(HasAction $hasActionsReceiver): self
    {
        if ($this->hasActionsReceiver->contains($hasActionsReceiver)) {
            $this->hasActionsReceiver->removeElement($hasActionsReceiver);
            // set the owning side to null (unless already changed)
            if ($hasActionsReceiver->getReceiver() === $this) {
                $hasActionsReceiver->setReceiver(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Logbook[]
     */
    public function getLogbooksSend(): Collection
    {
        return $this->logbooksSend;
    }

    public function addLogbooksSend(Logbook $logbooksSend): self
    {
        if (!$this->logbooksSend->contains($logbooksSend)) {
            $this->logbooksSend[] = $logbooksSend;
            $logbooksSend->setSend($this);
        }

        return $this;
    }

    public function removeLogbooksSend(Logbook $logbooksSend): self
    {
        if ($this->logbooksSend->contains($logbooksSend)) {
            $this->logbooksSend->removeElement($logbooksSend);
            // set the owning side to null (unless already changed)
            if ($logbooksSend->getSend() === $this) {
                $logbooksSend->setSend(null);
            }
        }

        return $this;
    }

    public function getWasteToTake(): ?WasteToTake
    {
        return $this->wasteToTake;
    }

    public function setWasteToTake(?WasteToTake $wasteToTake): self
    {
        $this->wasteToTake = $wasteToTake;

        return $this;
    }

    public function getTruckWaste(): ?TruckWaste
    {
        return $this->truckWaste;
    }

    public function setTruckWaste(?TruckWaste $truckWaste): self
    {
        $this->truckWaste = $truckWaste;

        // set (or unset) the owning side of the relation if necessary
        $newCharacters = null === $truckWaste ? null : $this;
        if ($truckWaste->getCharacters() !== $newCharacters) {
            $truckWaste->setCharacters($newCharacters);
        }

        return $this;
    }

    public function getJobPresentation(): ?string
    {
        return $this->jobPresentation;
    }

    public function setJobPresentation(string $jobPresentation): self
    {
        $this->jobPresentation = $jobPresentation;

        return $this;
    }

    /**
     * @return Collection|ObjectCharacter[]
     */
    public function getObjectCharacters(): Collection
    {
        return $this->objectCharacters;
    }

    public function addObjectCharacter(ObjectCharacter $objectCharacter): self
    {
        if (!$this->objectCharacters->contains($objectCharacter)) {
            $this->objectCharacters[] = $objectCharacter;
            $objectCharacter->setCharacters($this);
        }

        return $this;
    }

    public function removeObjectCharacter(ObjectCharacter $objectCharacter): self
    {
        if ($this->objectCharacters->contains($objectCharacter)) {
            $this->objectCharacters->removeElement($objectCharacter);
            // set the owning side to null (unless already changed)
            if ($objectCharacter->getCharacters() === $this) {
                $objectCharacter->setCharacters(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Store[]
     */
    public function getStores(): Collection
    {
        return $this->stores;
    }

    public function addStore(Store $store): self
    {
        if (!$this->stores->contains($store)) {
            $this->stores[] = $store;
            $store->setCharacters($this);
        }

        return $this;
    }

    public function removeStore(Store $store): self
    {
        if ($this->stores->contains($store)) {
            $this->stores->removeElement($store);
            // set the owning side to null (unless already changed)
            if ($store->getCharacters() === $this) {
                $store->setCharacters(null);
            }
        }

        return $this;
    }

    public function getHouse(): ?House
    {
        return $this->house;
    }

    public function setHouse(?House $house): self
    {
        $this->house = $house;

        return $this;
    }

    public function getHouseProperty(): ?int
    {
        return $this->houseProperty;
    }

    public function setHouseProperty(int $houseProperty): self
    {
        $this->houseProperty = $houseProperty;

        return $this;
    }

    /**
     * @return Collection|HouseFurniture[]
     */
    public function getHouseFurniture(): Collection
    {
        return $this->houseFurniture;
    }

    public function addHouseFurniture(HouseFurniture $houseFurniture): self
    {
        if (!$this->houseFurniture->contains($houseFurniture)) {
            $this->houseFurniture[] = $houseFurniture;
            $houseFurniture->addCharacter($this);
        }

        return $this;
    }

    public function removeHouseFurniture(HouseFurniture $houseFurniture): self
    {
        if ($this->houseFurniture->contains($houseFurniture)) {
            $this->houseFurniture->removeElement($houseFurniture);
            $houseFurniture->removeCharacter($this);
        }

        return $this;
    }

    /**
     * @return Collection|StudiesCharacters[]
     */
    public function getStudies(): Collection
    {
        return $this->studies;
    }

    public function addStudy(StudiesCharacters $study): self
    {
        if (!$this->studies->contains($study)) {
            $this->studies[] = $study;
            $study->setCharacters($this);
        }

        return $this;
    }

    public function removeStudy(StudiesCharacters $study): self
    {
        if ($this->studies->contains($study)) {
            $this->studies->removeElement($study);
            // set the owning side to null (unless already changed)
            if ($study->getCharacters() === $this) {
                $study->setCharacters(null);
            }
        }

        return $this;
    }

    public function getNewsReaded(): ?int
    {
        return $this->newsReaded;
    }

    public function setNewsReaded(int $newsReaded): self
    {
        $this->newsReaded = $newsReaded;

        return $this;
    }

    /**
     * @return Collection|DiseaseCharacter[]
     */
    public function getDiseaseCharacters(): Collection
    {
        return $this->diseaseCharacters;
    }

    public function addDiseaseCharacter(DiseaseCharacter $diseaseCharacter): self
    {
        if (!$this->diseaseCharacters->contains($diseaseCharacter)) {
            $this->diseaseCharacters[] = $diseaseCharacter;
            $diseaseCharacter->setCharacters($this);
        }

        return $this;
    }

    public function removeDiseaseCharacter(DiseaseCharacter $diseaseCharacter): self
    {
        if ($this->diseaseCharacters->contains($diseaseCharacter)) {
            $this->diseaseCharacters->removeElement($diseaseCharacter);
            // set the owning side to null (unless already changed)
            if ($diseaseCharacter->getCharacters() === $this) {
                $diseaseCharacter->setCharacters(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Patient[]
     */
    public function getPatients(): Collection
    {
        return $this->patients;
    }

    public function addPatient(Patient $patient): self
    {
        if (!$this->patients->contains($patient)) {
            $this->patients[] = $patient;
            $patient->setPatient($this);
        }

        return $this;
    }

    public function removePatient(Patient $patient): self
    {
        if ($this->patients->contains($patient)) {
            $this->patients->removeElement($patient);
            // set the owning side to null (unless already changed)
            if ($patient->getPatient() === $this) {
                $patient->setPatient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Patient[]
     */
    public function getDoctorPatients(): Collection
    {
        return $this->doctorPatients;
    }

    public function addDoctorPatient(Patient $doctorPatient): self
    {
        if (!$this->doctorPatients->contains($doctorPatient)) {
            $this->doctorPatients[] = $doctorPatient;
            $doctorPatient->setDoctor($this);
        }

        return $this;
    }

    public function removeDoctorPatient(Patient $doctorPatient): self
    {
        if ($this->doctorPatients->contains($doctorPatient)) {
            $this->doctorPatients->removeElement($doctorPatient);
            // set the owning side to null (unless already changed)
            if ($doctorPatient->getDoctor() === $this) {
                $doctorPatient->setDoctor(null);
            }
        }

        return $this;
    }

    public function getMedicPriceSubscription(): ?MedicPriceSubscription
    {
        return $this->medicPriceSubscription;
    }

    public function setMedicPriceSubscription(?MedicPriceSubscription $medicPriceSubscription): self
    {
        $this->medicPriceSubscription = $medicPriceSubscription;

        // set (or unset) the owning side of the relation if necessary
        $newDoctor = null === $medicPriceSubscription ? null : $this;
        if ($medicPriceSubscription->getDoctor() !== $newDoctor) {
            $medicPriceSubscription->setDoctor($newDoctor);
        }

        return $this;
    }

    public function getTreatmentSubscription(): ?string
    {
        return $this->treatmentSubscription;
    }

    public function setTreatmentSubscription(?string $treatmentSubscription): self
    {
        $this->treatmentSubscription = $treatmentSubscription;

        return $this;
    }

    public function getPharmacy(): ?Pharmacy
    {
        return $this->pharmacy;
    }

    public function setPharmacy(?Pharmacy $pharmacy): self
    {
        $this->pharmacy = $pharmacy;

        // set (or unset) the owning side of the relation if necessary
        $newCharacters = null === $pharmacy ? null : $this;
        if ($pharmacy->getCharacters() !== $newCharacters) {
            $pharmacy->setCharacters($newCharacters);
        }

        return $this;
    }

    public function getPharmacyDemand(): ?PharmacyDemands
    {
        return $this->pharmacyDemand;
    }

    public function setPharmacyDemand(?PharmacyDemands $pharmacyDemand): self
    {
        $this->pharmacyDemand = $pharmacyDemand;

        // set (or unset) the owning side of the relation if necessary
        $newCharacters = null === $pharmacyDemand ? null : $this;
        if ($pharmacyDemand->getCharacters() !== $newCharacters) {
            $pharmacyDemand->setCharacters($newCharacters);
        }

        return $this;
    }

    public function getTreatmentTaken(): ?int
    {
        return $this->treatmentTaken;
    }

    public function setTreatmentTaken(int $treatmentTaken): self
    {
        $this->treatmentTaken = $treatmentTaken;

        return $this;
    }

    public function getMusicProfilLink(): ?string
    {
        return $this->musicProfilLink;
    }

    public function setMusicProfilLink(?string $musicProfilLink): self
    {
        $this->musicProfilLink = $musicProfilLink;

        return $this;
    }

    public function getStampStock(): ?StampStock
    {
        return $this->stampStock;
    }

    public function setStampStock(?StampStock $stampStock): self
    {
        $this->stampStock = $stampStock;

        // set (or unset) the owning side of the relation if necessary
        $newCharacters = null === $stampStock ? null : $this;
        if ($stampStock->getCharacters() !== $newCharacters) {
            $stampStock->setCharacters($newCharacters);
        }

        return $this;
    }

    public function getCasinoCoins(): ?int
    {
        return $this->casinoCoins;
    }

    public function setCasinoCoins(int $casinoCoins): self
    {
        $this->casinoCoins = $casinoCoins;

        return $this;
    }

    public function getCasinoGamePlayed(): ?int
    {
        return $this->casinoGamePlayed;
    }

    public function setCasinoGamePlayed(int $casinoGamePlayed): self
    {
        $this->casinoGamePlayed = $casinoGamePlayed;

        return $this;
    }

    public function getSportsRoom(): ?SportsRoom
    {
        return $this->sportsRoom;
    }

    public function setSportsRoom(SportsRoom $sportsRoom): self
    {
        $this->sportsRoom = $sportsRoom;

        // set the owning side of the relation if necessary
        if ($sportsRoom->getCoach() !== $this) {
            $sportsRoom->setCoach($this);
        }

        return $this;
    }


}
