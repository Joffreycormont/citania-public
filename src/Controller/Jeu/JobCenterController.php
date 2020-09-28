<?php

namespace App\Controller\Jeu;

use App\Entity\Characters;
use App\Entity\GlobalGameVariable;
use App\Entity\Jobs;
use App\Entity\Logbook;
use App\Entity\MedicPriceSubscription;
use App\Entity\Pharmacy;
use App\Entity\StampStock;
use App\Entity\StudiesCharacters;
use App\Entity\TruckWaste;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class JobCenterController extends AbstractController
{
    /**
     * @Route("/jeu/bureau-emploi", name="jeu_jobCenter")
     */
    public function index()
    {

        $jobList = $this->getDoctrine()->getRepository(Jobs::class)->findAll();

        return $this->render('jeu/map/jobCenter.html.twig', [
            'controller_name' => 'HomeGameController',
            'jobList' => $jobList
        ]);
        
    }

    /**
     * @Route("/jeu/bureau-emploi/candidature/job/unskilled/{id}", name="jeu_jobCenter_newjob_unSkilled")
     */
    public function newJobUnSkilled(Security $security, Jobs $jobs)
    {
        $characterToEdit= $security->getUser()->getCharacters();
        $em = $this->getDoctrine()->getManager();


        if($characterToEdit->getJob() !== null){
            if($characterToEdit->getJob()->getId() == $jobs->getId()){
                $this->addFlash('error', 'Tu occupes déjà ce poste');
                return $this->redirectToRoute('jeu_jobCenter');
            }
        }

        if($jobs->getSlug() == 'eboueur'){
            $checkTruck = $characterToEdit->getTruckWaste();

            if($checkTruck == null){
                $newTruck = new TruckWaste();
                $newTruck->setCapacity(0);
                $newTruck->setCharacters($characterToEdit);

                $em->persist($newTruck);
                $em->flush();
            }
        }elseif($jobs->getSlug() == 'facteur'){
            $checkStampStock = $characterToEdit->getStampStock();

            if($checkStampStock == null){
                $newStampStock = new StampStock();
                $newStampStock->setQuantity(0);
                $newStampStock->setPrice(0);
                $newStampStock->setCharacters($characterToEdit);
                $newStampStock->setPostedLetter(0);

                $em->persist($newStampStock);
                $em->flush();
            }
        }

        $characterToEdit->setJob($jobs);

        $newLogbookEntry = new Logbook();
        $newLogbookEntry->setCharacters($characterToEdit);
        $newLogbookEntry->setSend($characterToEdit);
        $newLogbookEntry->setEvent('Emploi');
        $newLogbookEntry->setContent('Félicitations tu es maintenant : '.$characterToEdit->getjob()->getName());

        $em->persist($characterToEdit);
        $em->persist($newLogbookEntry);
        $em->flush();

        $this->addFlash('success', 'Félicitations pour ton nouveau travail !');
        return $this->redirectToRoute('jeu_jobCenter');
        
    }

        /**
     * @Route("/jeu/bureau-emploi/candidature/job/skilled/{id}", name="jeu_jobCenter_newjob_Skilled")
     */
    public function newJobSkilled(Security $security, Jobs $jobs)
    {
        $characterToEdit = $security->getUser()->getCharacters();
        $em = $this->getDoctrine()->getManager();


        if($characterToEdit->getJob() !== null){
            if($characterToEdit->getJob()->getId() == $jobs->getId()){
                $this->addFlash('error', 'Tu occupes déjà ce poste');
                return $this->redirectToRoute('jeu_jobCenter');
            }
        }

        $checkIfHasDiplome = $this->getDoctrine()->getRepository(StudiesCharacters::class)->checkIfHasDiplome($jobs, $characterToEdit);
        
        if(!empty($checkIfHasDiplome)){

            if($jobs->getSlug() == 'medic'){
                $checkMedicSubscription = $characterToEdit->getMedicPriceSubscription();
    
                if($checkMedicSubscription == null){
                    $newMedicSubscription = new MedicPriceSubscription();
                    $newMedicSubscription->setPrice(0);
                    $newMedicSubscription->setPriceConsultation(0);
                    $newMedicSubscription->setDoctor($characterToEdit);
    
                    $em->persist($newMedicSubscription);
                    $em->flush();
                }

            }elseif($jobs->getSlug() == 'pharmacien'){
                $governmentMoney = $this->getDoctrine()->getRepository(GlobalGameVariable::class)->findBy(['name' => 'GOVERNMENT_MONEY'])[0];
                $checkIfHavePharmacy = $this->getDoctrine()->getRepository(Pharmacy::class)->findBy(['characters' => $characterToEdit]);

                $governmentMoney->setValue($governmentMoney->getValue() - 5000);

                // TODO notification pour le gouvernement de la création d'une pharmacie.

                if($checkIfHavePharmacy == null){
                    $newPharmacy = new Pharmacy();
                    $newPharmacy->setMoney(5000);
                    $newPharmacy->setCharacters($characterToEdit);
                    $newPharmacy->setOwnerSalary(0);
    
                    $em->persist($newPharmacy);
                    $em->flush();
                }
            }

            $characterToEdit->setJob($jobs);

            $newLogbookEntry = new Logbook();
            $newLogbookEntry->setCharacters($characterToEdit);
            $newLogbookEntry->setSend($characterToEdit);
            $newLogbookEntry->setEvent('Emploi');
            $newLogbookEntry->setContent('Félicitations tu es maintenant : '.$characterToEdit->getjob()->getName());
    
            $em->persist($characterToEdit);
            $em->persist($newLogbookEntry);
            $em->flush();
    
            $this->addFlash('success', 'Félicitations pour ton nouveau travail !');
            return $this->redirectToRoute('jeu_jobCenter');
        }else{
            $this->addFlash('error', 'Tu n\'as pas le/les diplôme(s) nécessaire(s) pour exercer ce métier');
            return $this->redirectToRoute('jeu_jobCenter');
        }
        
    }



}
