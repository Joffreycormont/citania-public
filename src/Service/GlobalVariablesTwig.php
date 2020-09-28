<?php

namespace App\Service;

use App\Entity\Characters;
use App\Entity\Comments;
use App\Entity\FriendRequests;
use App\Entity\Logbook;
use App\Entity\Messages;
use App\Entity\Patient;
use App\Entity\PharmacyDemands;
use App\Entity\WasteToTake;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;

class GlobalVariablesTwig
{

    private $security;
    private $em;


    public function __construct(Security $security, EntityManagerInterface $em)
    {
        $this->security = $security;
        $this->em = $em;
    }


    public function commentsList ()
    {
        $security = $this->security;

        $user = $security->getUser()->getCharacters();
        $userId = $user->getId();

        $commentsList = $this->em->getRepository(Comments::class)->findWaitingComments($userId);

        $commentCount = count($commentsList);

        return $commentCount;

    }

    public function MessagesList ()
    {
        $security = $this->security;

        $user = $security->getUser()->getCharacters();
        $userId = $user->getId();

        $messagesList = $this->em->getRepository(Messages::class)->getLastMessageForReceiver($userId);
        $messagesCount = count($messagesList);

        return $messagesCount;

    }

    public function EventList ()
    {
        $security = $this->security;

        $user = $security->getUser()->getCharacters();
        $userId = $user->getId();

        $logbookList = $this->em->getRepository(Logbook::class)->getUnReadEvent($userId);
        $logbookCount = count($logbookList);

        return $logbookCount;

    }

    public function friendRequestList ()
    {
        $security = $this->security;

        $user = $security->getUser()->getCharacters();
        $userId = $user->getId();

        $friendRequestList = $this->em->getRepository(FriendRequests::class)->findByReceiverIdWaiting($userId);
        $friendRequestCount = count($friendRequestList);

        return $friendRequestCount;

    }

    public function jobNotification ()
    {
        $security = $this->security;

        $user = $security->getUser()->getCharacters();
        $userId = $user->getId();

        if($user->getJob() !== null){
            $userJobSlug = $user->getJob()->getSlug();

            switch($userJobSlug){
                // Eboueur
                case 'eboueur':
                    $jobNotification = count($this->em->getRepository(WasteToTake::class)->findAll());
                    return $jobNotification;
                    break;
                // Médecin    
                case 'medic':
                    $jobNotification = 0;
                    $patientList = $this->em->getRepository(Patient::class)->findPatientByMedic($user);
                    $consultationDemands = $this->em->getRepository(Patient::class)->findPatientConsultationByMedic($user);

                    $jobNotification += $consultationDemands;

                    foreach($patientList as $patient){
                        $patientDiseases = count($patient->getPatient()->getDiseaseCharacters());
                        $patientLife = $patient->getPatient()->getLife();

                        if($patientLife < 80){
                            $jobNotification++;
                        }

                        if($patientDiseases > 0){
                            $jobNotification++;
                        }
                    }
                    return $jobNotification;
                    break;
                // Pharmacien
                case 'pharmacien':

                    $characterPharmacy = $user->getPharmacy();
                    $jobNotification = count($this->em->getRepository(PharmacyDemands::class)->findBy(['pharmacy' => $characterPharmacy]));

                    return $jobNotification;
                    break;

                // Facteur
                case 'facteur':

                    $jobNotification = count($this->em->getRepository(Messages::class)->findBy(['status' => 0]));

                    return $jobNotification;
                    break;                
            }
        }
        
        return 0;
    }

    public function charactersInfo()
    {
        $security = $this->security;
        $user = $security->getUser();

        $character = $this->em->getRepository(Characters::class)->findCharacter($user->getCharacters()->getId(), $user->getCharacters());

        return $character[0];
    }
}