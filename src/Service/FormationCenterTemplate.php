<?php
namespace App\Service;

use App\Entity\Logbook;
use App\Entity\StudiesCharacters;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class FormationCenterTemplate extends AbstractController
{

    private $em;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function GetInsertionTemplate($characterToEdit, $studies, $mode)
    {
        $newFormation = new StudiesCharacters();
        $newLogbookEntry = new Logbook();

        if($mode == 'withoutProf'){
            $characterMoney = $characterToEdit->getMoney();
            $totalPrice = $studies->getPrice() + 500;
    
            if($characterMoney < $totalPrice){
                $this->addFlash('error', 'Tu n\'as pas assez d\'argent pour la formation');
                return $this->redirectToRoute('jeu_formationCenter');
            }
            
            $characterToEdit->setMoney($characterMoney - $totalPrice);
            $newFormation->setIsVip(0);
            $newFormation->setDurationStatus(0);

            $newLogbookEntry->setContent('Félicitations tu commences ta formation : <strong>'.$studies->getName().'</strong> en mode sans professeur');

        }elseif($mode == 'vip'){
            $characterDiamond = $characterToEdit->getDiamond();
            $totalPrice = $studies->getPriceDiamond();

            if($characterDiamond < $totalPrice){
                $this->addFlash('error', 'Tu n\'as pas assez de diamants pour la formation');
                return $this->redirectToRoute('jeu_formationCenter');
            }

            $characterToEdit->setDiamond($characterDiamond - $totalPrice);
            $newFormation->setIsVip(1);
            $newFormation->setDurationStatus($studies->getDuration());

            $newLogbookEntry->setContent('Félicitations tu commences ta formation : <strong>'.$studies->getName().'</strong> en mode vip');
        }

        $newFormation->setStudy($studies);
        $newFormation->setCharacters($characterToEdit);
        $newFormation->setStatus(0);
        $newFormation->setYearStatus(0);

        $newLogbookEntry->setCharacters($characterToEdit);
        $newLogbookEntry->setSend($characterToEdit);
        $newLogbookEntry->setEvent('Formation');

        $this->em->persist($newFormation);
        $this->em->persist($characterToEdit);
        $this->em->persist($newLogbookEntry);
        $this->em->flush();
    }
}