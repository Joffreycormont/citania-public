<?php

namespace App\Controller\Jeu\Jobs;

use App\Entity\Characters;
use App\Entity\FactorPrimes;
use App\Entity\Jobs;
use App\Entity\Messages;
use App\Entity\Patient;
use App\Entity\PharmacyTreatmentStock;
use App\Entity\Treatment;
use App\Entity\WasteToTake;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class MainJobController extends AbstractController
{
    /**
     * @Route("/jeu/mon_boulot", name="jeu_work")
     */
    public function index(Security $security, PaginatorInterface $paginator, Request $request)
    {

        $user = $security->getuser()->getCharacters();

        switch($user->getJob()->getSlug()){
            // Eboueur
            case 'eboueur':

                $wasteToTakeList = $this->getDoctrine()->getRepository(WasteToTake::class)->findAll();

                return $this->render('jeu/jobs/eboueurWork.html.twig', [
                    'controller_name' => 'HomeGameController',
                    'wasteList' => $wasteToTakeList,
                ]);
                break;

            // Médecin
            case 'medic':

                $treatmentList = $this->getDoctrine()->getRepository(Treatment::class)->findAll();
                $consultationCount = $this->getDoctrine()->getRepository(Patient::class)->findPatientConsultationByMedic($user);

                return $this->render('jeu/jobs/medicWork.html.twig', [
                    'controller_name' => 'HomeGameController',
                    'treatmentList' => $treatmentList,
                    'consultationCount' => $consultationCount
                ]);
                break;

            // Pharmacien
            case 'pharmacien':

                $treatmentList = $this->getDoctrine()->getRepository(Treatment::class)->findAll();

                return $this->render('jeu/jobs/pharmacienWork.html.twig', [
                    'controller_name' => 'HomeGameController',
                    'treatmentList' => $treatmentList
                ]);
                break;                

            // Facteur
            case 'facteur':

                $messageListToValid = $this->getDoctrine()->getRepository(Messages::class)->findBy(['status' => 0]);
                $factorPriceList = $this->getDoctrine()->getRepository(FactorPrimes::class)->findAll();

                return $this->render('jeu/jobs/factorWork.html.twig', [
                    'controller_name' => 'HomeGameController',
                    'messageList' => $messageListToValid,
                    'factorPriceList' => $factorPriceList
                ]);
                break;
                
            // Coach sportif
            case 'coach':

                return $this->render('jeu/jobs/coachWork.html.twig', [
                    'controller_name' => 'HomeGameController',
                ]);
                break;                

            default:
                
        }        
    }

    /**
     * @Route("/jeu/boulot/visite/{id}", name="jeu_work_visit")
     */
    public function JobForVisitor(Security $security, Characters $characters, PaginatorInterface $paginator, Request $request)
    {

        $user = $security->getuser()->getCharacters();
        $job = $user->getJob();

        switch($characters->getJob()->getSlug()){
            //Métier éboueur
            case 'eboueur':

                return $this->render('jeu/jobs/visit/eboueurVisit.html.twig', [
                    'controller_name' => 'HomeGameController',
                    'job' => $job,
                    'character' => $characters
                ]);
                break;

            // Medic
            case 'medic':
                
                return $this->render('jeu/jobs/visit/medicVisit.html.twig', [
                    'controller_name' => 'HomeGameController',
                    'job' => $job,
                    'character' => $characters
                ]);
                break;

            // pharmacien
            case 'pharmacien':

                $pharmacy = $characters->getPharmacy();
                $treatmentListInPharmacy = $this->getDoctrine()->getRepository(PharmacyTreatmentStock::class)->findBy(['pharmacy' => $pharmacy]);
                
                return $this->render('jeu/jobs/visit/pharmacienVisit.html.twig', [
                    'controller_name' => 'HomeGameController',
                    'job' => $job,
                    'character' => $characters,
                    'treatmentList' => $treatmentListInPharmacy
                ]);
                break;

            // Facteur
            case 'facteur':

                return $this->render('jeu/jobs/visit/factorVisit.html.twig', [
                    'controller_name' => 'HomeGameController',
                    'character' => $characters
                    
                ]);
                break;
                
            // Coach sportif
            case 'coach':

                return $this->render('jeu/jobs/visit/coachVisit.html.twig', [
                    'controller_name' => 'HomeGameController',
                    'character' => $characters
                ]);
                break;                 

            default:
        }        
    }

    /**
     * @Route("/jeu/boulot/editPresentation", name="jeu_work_editPresentation", methods={"POST"})
     */
    public function editPresentation(Security $security, PaginatorInterface $paginator, Request $request)
    {

        $presentation = $request->request->get('content');
        
        $user = $security->getuser()->getCharacters();

        $user->setJobPresentation($presentation);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $this->addFlash('success', 'Modification de ta présentation effectué');
        return $this->redirectToRoute('jeu_work');
              
    }





}
