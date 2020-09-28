<?php

namespace App\Controller\Jeu\Jobs;

use App\Entity\Characters;
use App\Entity\DiseaseCharacter;
use App\Entity\Logbook;
use App\Entity\MedicPriceSubscription;
use App\Entity\Patient;
use App\Entity\Treatment;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class MedicController extends AbstractController
{
    /**
     * @Route("/jeu/mon_boulot/medecin/updatePrice/{id}", name="work_medic_updatePrice")
     */
    public function updatePrice(Security $security, Request $request, MedicPriceSubscription $medicPrice)
    {
        $character = $security->getUser()->getCharacters();
        $em = $this->getDoctrine()->getManager();
        $doctorPatientsSuscribed = $this->getDoctrine()->getRepository(Patient::class)->findBySubscriptionAndMedic($character);

        if($character->getId() == $medicPrice->getDoctor()->getId()){

            if($request->request->get('price')){

                if($request->request->get('price') < 0){
                    $this->addFlash('error', 'Tu ne peux pas mettre de valeur négative');
                    $url = $this->generateUrl('jeu_work');
                    return $this->redirect($url.'#jobAction');
                }

                if($request->request->get('price') > 999){
                    $this->addFlash('error', 'Prix max : 999 €');
                    $url = $this->generateUrl('jeu_work');
                    return $this->redirect($url.'#jobAction');
                }

                $medicPrice->setPrice($request->request->get('price'));

                foreach($doctorPatientsSuscribed as $patient){

                    $newLogbookEntry = new Logbook();
                    $newLogbookEntry->setCharacters($patient->getPatient());
                    $newLogbookEntry->setSend($character);
                    $newLogbookEntry->setEvent('Sante');
                    $newLogbookEntry->setContent('Ton médecin traitant <strong>'. $character->getFirstname().' - '. $character->getLastname().'</strong> a modifié le prix de ses abonnements, le coût journalier est maintenant de :<strong>'.$request->request->get('price').' € </strong>/jour');

                    $em->persist($newLogbookEntry);
                }

                $em->persist($medicPrice);

                $this->addFlash('success', 'Prix de l\'abonnement modifié avec succès');
                
            }elseif($request->request->get('priceConsultation')){

                if($request->request->get('priceConsultation') < 0){
                    $this->addFlash('error', 'Tu ne peux pas mettre de valeur négative');
                    $url = $this->generateUrl('jeu_work');
                    return $this->redirect($url.'#jobAction');
                }

                if($request->request->get('priceConsultation') > 999){
                    $this->addFlash('error', 'Prix max : 999 €');
                    $url = $this->generateUrl('jeu_work');
                    return $this->redirect($url.'#jobAction');
                }

                $medicPrice->setPriceConsultation($request->request->get('priceConsultation'));
                $em->persist($medicPrice);
                $this->addFlash('success', 'Prix de la consultation modifié avec succès');

            }

            $em->flush();
            $url = $this->generateUrl('jeu_work');
            return $this->redirect($url.'#jobAction');
        }

    }

    /**
     * @Route("/jeu/mon_boulot/medecin/cancelSub/{id}", name="work_medic_cancelSub")
     */
    public function cancelSub(Security $security, Patient $patient)
    {
        $character = $security->getUser()->getCharacters();

        if($character->getId() == $patient->getDoctor()->getId()){
            $em = $this->getDoctrine()->getManager();
            $em->remove($patient);

            $newLogbookEntry = new Logbook();
            $newLogbookEntry->setCharacters($patient->getPatient());
            $newLogbookEntry->setSend($character);
            $newLogbookEntry->setEvent('Sante');
            $newLogbookEntry->setContent('Ton abonnement a été supprimé par ton médecin traitant <strong>'. $character->getFirstname().' - '. $character->getLastname().'</strong>');

            $em->persist($newLogbookEntry);
            $em->flush();

            $this->addFlash('success', 'Abonnement supprimé/ consultation refusée');
            $url = $this->generateUrl('jeu_work');
            return $this->redirect($url.'#jobAction');
        }
    }

    /**
     * @Route("/jeu/mon_boulot/medecin/cancelConsultation/{id}", name="work_medic_cancelConsultation")
     */
    public function cancelConsultation(Security $security, Patient $patient)
    {
        $character = $security->getUser()->getCharacters();

        if($character->getId() == $patient->getDoctor()->getId()){
            $em = $this->getDoctrine()->getManager();
            $em->remove($patient);

            $newLogbookEntry = new Logbook();
            $newLogbookEntry->setCharacters($patient->getPatient());
            $newLogbookEntry->setSend($character);
            $newLogbookEntry->setEvent('Sante');
            $newLogbookEntry->setContent('Ta demande de consultation a été refusée par <strong>'. $character->getFirstname().' - '. $character->getLastname().'</strong>');

            $em->persist($newLogbookEntry);
            $em->flush();

            $this->addFlash('success', 'Abonnement supprimé/ consultation refusée');
            $url = $this->generateUrl('jeu_work');
            return $this->redirect($url.'#jobAction');
        }
    }

    

    /**
     * @Route("/jeu/mon_boulot/medecin/auscultation/{id}", name="work_medic_auscultation")
     */
    public function auscultation(Security $security, Patient $patient)
    {
        $character = $security->getUser()->getCharacters();
        $patientCharacter = $patient->getPatient();

        if($character->getId() == $patient->getDoctor()->getId()){
            $em = $this->getDoctrine()->getManager();

            $patientCharacter->setLife(100);

            $newLogbookEntry = new Logbook();
            $newLogbookEntry->setCharacters($patient->getPatient());
            $newLogbookEntry->setSend($character);
            $newLogbookEntry->setEvent('Sante');
            $newLogbookEntry->setContent('Ta barre de vie a été remontée à 100 % par le médecin <strong>'. $character->getFirstname().' - '. $character->getLastname().'</strong>');

            $em->persist($patientCharacter);
            $em->persist($newLogbookEntry);
            $em->flush();

            $this->addFlash('success', 'Auscultation effectuée');
            $url = $this->generateUrl('jeu_work');
            return $this->redirect($url.'#jobAction');
        }
    }

    /**
     * @Route("/jeu/mon_boulot/medecin/diagnostic/{id}/{patient}", name="work_medic_diagnostic")
     */
    public function diagnostic(Security $security, DiseaseCharacter $disease, Patient $patient)
    {
        $character = $security->getUser()->getCharacters();

        if($character->getId() == $patient->getDoctor()->getId()){
            $em = $this->getDoctrine()->getManager();

            $disease->setDiseaseDiscoverStatus(1);
            $em->persist($disease);
            $em->flush();

            $this->addFlash('success', 'Maladie diagnostiquée ! Votre patient est atteint d\'un(e) '.$disease->getDisease()->getName());
            $url = $this->generateUrl('jeu_work');
            return $this->redirect($url.'#jobAction');
        }
    }

    /**
     * @Route("/jeu/mon_boulot/medecin/prescription/patient/{id}", name="work_medic_prescription")
     */
    public function givePrescription(Security $security, Patient $patient, Request $request)
    {
        $character = $security->getUser()->getCharacters();
        $patientCharacter = $patient->getPatient();
        $em = $this->getDoctrine()->getManager();
        $currentDiseaseList = $patient->getPatient()->getDiseaseCharacters();
        $diseasesToDisplay = 
        $allTreatmentIds = "";
        $treatmentCounter = 0;

        if($request->request->all() == null){
            $this->addFlash('error', 'Tu peux pas valider l\'ordonnance si elle est vide');
            $url = $this->generateUrl('jeu_work');
            return $this->redirect($url.'#jobAction');
        }

        foreach($currentDiseaseList as $disease){
            $diseasesToDisplay .= '-'.$disease->getDisease()->getName().'<br> ';
        }

        foreach($request->request->all() as $treatmentId){

            $checkTreatmentWithDisease = $this->getDoctrine()->getRepository(Treatment::class)->find($treatmentId);

            if($checkTreatmentWithDisease != null){
                foreach($currentDiseaseList as $currentDisease){
                    if($currentDisease->getDisease()->getId() == $checkTreatmentWithDisease->getDisease()->getId()){
                        $treatmentCounter++;
                    }
                }
            }
            $allTreatmentIds .= $treatmentId.' ';
        }

        if($treatmentCounter != count($currentDiseaseList)){
            $this->addFlash('error', 'Les traitements que tu as renseignés ne correspondent pas avec les maladies du patient');
            $url = $this->generateUrl('jeu_work');
            return $this->redirect($url.'#jobAction');
        }

        $allTreatmentIds = substr($allTreatmentIds, 0, -1);

        if($character->getId() == $patient->getDoctor()->getId()){
 
            $patientCharacter->setTreatmentSubscription($allTreatmentIds);

            $newLogbookEntry = new Logbook();
            $newLogbookEntry->setCharacters($patient->getPatient());
            $newLogbookEntry->setSend($character);
            $newLogbookEntry->setEvent('Sante');
            $newLogbookEntry->setContent('Ton médecin t\'a diagnostiqué la/les maladies suivantes <br> :'. $diseasesToDisplay.'</strong><br>, tu viens de recevoir ton ordonnance, va vite récupérer tes médicaments chez un pharmacien');

            if($patient->getHaveSubscription() == 0){
                $patientCharacter->setMoney($patientCharacter->getMoney() - $character->getMedicPriceSubscription()->getPriceConsultation());
                $character->setMoney($character->getMoney() + $character->getMedicPriceSubscription()->getPriceConsultation());
            }

            $patientCharacter->setTreatmentTaken(1);
            $em->persist($patientCharacter);
            $em->persist($newLogbookEntry);

            if($patient->getHaveSubscription() == 0){
                $em->remove($patient);
            }

            $em->flush();

            $this->addFlash('success', 'Ordonnance prescrite à ton patient avec succès');

            $url = $this->generateUrl('jeu_work');
            return $this->redirect($url.'#jobAction');
        }
    }

    /**
     * @Route("/jeu/mon_boulot/medecin/recallTreatment/patient/{id}", name="work_medic_recall_treatment")
     */
    public function recallTreatment(Security $security, Patient $patient)
    {
        $character = $security->getUser()->getCharacters();
        $em = $this->getDoctrine()->getManager();

        if($character->getId() == $patient->getDoctor()->getId()){
 
            $newLogbookEntry = new Logbook();
            $newLogbookEntry->setCharacters($patient->getPatient());
            $newLogbookEntry->setSend($character);
            $newLogbookEntry->setEvent('Sante');
            $newLogbookEntry->setContent('Ton médecin t\'envoi un rappel, tu a un/des traitement(s) en attente(s) pour ta/tes maladie(s), attention ne fait pas trop traîner !');

            $patient->setRecallTreatmentStatus(1);
            
            $em->persist($newLogbookEntry);
            $em->persist($patient);
            $em->flush();

            $this->addFlash('success', 'Rappel à ton patient effectué avec succès');

            $url = $this->generateUrl('jeu_work');
            return $this->redirect($url.'#jobAction');
        }
    }

    /**
     * @Route("/jeu/mon_boulot/medecin/{id}/visit/newSub/accept", name="work_medic_visit_newSub_accept")
     */
    public function acceptNewSub(Security $security, Patient $patient)
    {
        $character = $security->getUser()->getCharacters();
        $em = $this->getDoctrine()->getManager();

        if($character->getId() == $patient->getDoctor()->getId()){
            $patient->setAcceptedStatus(1);
        
            $newLogbookEntry = new Logbook();
            $newLogbookEntry->setCharacters($patient->getPatient());
            $newLogbookEntry->setSend($character);
            $newLogbookEntry->setEvent('Sante');
            $newLogbookEntry->setContent('Ta demande d\'abonnement chez le médecin <strong>'.$character->getFirstname().' - '.$character->getLastname().'</strong> a été acceptée');

            $em->persist($newLogbookEntry);
            $em->persist($patient);
            $em->flush();

            $this->addFlash('success', 'Nouveau/velle patient(e) abonné(e) avec succès');

            $url = $this->generateUrl('jeu_work');
            return $this->redirect($url.'#jobAction');
        }
    }

    /**
     * @Route("/jeu/mon_boulot/medecin/{id}/visit/newSub/deny", name="work_medic_visit_newSub_deny")
     */
    public function denyNewSub(Security $security, Patient $patient)
    {
        $character = $security->getUser()->getCharacters();
        $em = $this->getDoctrine()->getManager();

        if($character->getId() == $patient->getDoctor()->getId()){
            $em->remove($patient);
        
            $newLogbookEntry = new Logbook();
            $newLogbookEntry->setCharacters($patient->getPatient());
            $newLogbookEntry->setSend($character);
            $newLogbookEntry->setEvent('Sante');
            $newLogbookEntry->setContent('Ta demande d\'abonnement chez le médecin <strong>'.$character->getFirstname().' - '.$character->getLastname().'</strong> a été refusée');

            $em->persist($newLogbookEntry);

            $em->flush();

            $this->addFlash('success', 'Patient refusé avec succès');

            $url = $this->generateUrl('jeu_work');
            return $this->redirect($url.'#jobAction');
        }
    }

    /**
     * @Route("/jeu/mon_boulot/medecin/{id}/visit/newSub/deny/fromVisitor", name="work_medic_visit_deny_visitor")
     */
    public function denyFromVisitor(Security $security, Patient $patient)
    {
        $character = $security->getUser()->getCharacters();
        $em = $this->getDoctrine()->getManager();

        if($character->getId() == $patient->getPatient()->getId()){
            
            $em->remove($patient);
            $em->flush();

            $this->addFlash('success', 'Demande annulée avec succès');
            return $this->redirectToRoute('jeu_work_visit', ['id' => $patient->getDoctor()->getId()]);
        }
    }

    /**
     * @Route("/jeu/mon_boulot/medecin/{doctor}/visit/newSub", name="work_medic_visit_newSub")
     */
    public function newSub(Security $security, Characters $doctor)
    {
        // For visitor
        $character = $security->getUser()->getCharacters();
        $em = $this->getDoctrine()->getManager();

        $checkIfIsAlreadyPatient = $this->getDoctrine()->getRepository(Patient::class)->findBy(['patient' => $character->getId()]);

        if($doctor->getId() == $character->getId()){
            $this->addFlash('error', 'Tu ne peux pas faire une demande dans ton propre cabinet');
            return $this->redirectToRoute('jeu_work_visit', ['id' => $doctor->getId()]);
        }

        if(!$checkIfIsAlreadyPatient){
            
            $newPatient = new Patient();
            $newPatient->setPatient($character);
            $newPatient->setDoctor($doctor);
            $newPatient->setRecallTreatmentStatus(0);
            $newPatient->setHaveSubscription(1);
            $newPatient->setAcceptedStatus(0);

            $em->persist($newPatient);
            $em->flush();

            $this->addFlash('success', 'Tu as bien fait ta demande d\'abonnement chez ce médecin avec succès');
            return $this->redirectToRoute('jeu_work_visit', ['id' => $doctor->getId()]);

        }else{
            $this->addFlash('error', 'Tu as déjà fait une demande d\'abonnement ou de consultation chez un médecin ou possède déjà un médecin traitant.');
            return $this->redirectToRoute('jeu_work_visit', ['id' => $doctor->getId()]);
        }

        exit;

    }

    /**
     * @Route("/jeu/mon_boulot/medecin/{doctor}/visit/newConsultation", name="work_medic_newConsultation")
     */
    public function newConsultation(Security $security, Characters $doctor)
    {
        // For visitor
        $character = $security->getUser()->getCharacters();
        $em = $this->getDoctrine()->getManager();

        $checkIfIsAlreadyPatient = $this->getDoctrine()->getRepository(Patient::class)->findBy(['patient' => $character->getId()]);

        if($doctor->getId() == $character->getId()){
            $this->addFlash('error', 'Tu ne peux pas faire une demande dans ton propre cabinet');
            return $this->redirectToRoute('jeu_work_visit', ['id' => $doctor->getId()]);
        }

        if(!$checkIfIsAlreadyPatient){

            $newPatient = new Patient();
            $newPatient->setPatient($character);
            $newPatient->setDoctor($doctor);
            $newPatient->setRecallTreatmentStatus(0);
            $newPatient->setHaveSubscription(0);
            $newPatient->setAcceptedStatus(0);

            $em->persist($newPatient);
            $em->flush();

            $this->addFlash('success', 'Tu as bien fait ta demande d\'abonnement chez ce médecin avec succès');
            return $this->redirectToRoute('jeu_work_visit', ['id' => $doctor->getId()]);
            
        }else{
            $this->addFlash('error', 'Tu as déjà fait une demande d\'abonnement ou de consultation chez un médecin ou possède déjà un médecin traitant.');
            return $this->redirectToRoute('jeu_work_visit', ['id' => $doctor->getId()]);
        }
    }


}
