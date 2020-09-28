<?php

namespace App\Controller\Jeu;


use App\Entity\Studies;
use App\Entity\StudiesCharacters;
use App\Service\FormationCenterTemplate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class FormationCenterController extends AbstractController
{
    /**
     * @Route("/jeu/centre_de_formation", name="jeu_formationCenter")
     */
    public function index()
    {

        $studiesList = $this->getDoctrine()->getRepository(Studies::class)->findAll();

        return $this->render('jeu/map/formationCenter.html.twig', [
            'controller_name' => 'HomeGameController',
            'studiesList' => $studiesList
        ]);
        
    }

    /**
     * @Route("/jeu/centre_de_formation/nouvelle_formation/{id}/{mode}", name="jeu_formationCenter_newFormation")
     * 
     */
    public function newFormation(Security $security, Studies $studies, $mode, FormationCenterTemplate $formationCenterTemplate)
    {
        // fonction pour le choix de formation sans professeur -> implique le coût de la formation + 500 €

        $characterToEdit= $security->getUser()->getCharacters();
        $em = $this->getDoctrine()->getManager();

        if($characterToEdit->getStudies() !== null){

            $checkIfAlreadyHave = $this->getDoctrine()->getRepository(StudiesCharacters::class)->checkIfAlreadyHave($studies, $characterToEdit);

            if(count($checkIfAlreadyHave) > 0){
                $this->addFlash('error', 'Tu as déjà fait cette formation');
                return $this->redirectToRoute('jeu_formationCenter');
            }

            $othersStudiesRequired = $studies->getOthersStudiesRequired();

            if(!empty($othersStudiesRequired)){
                $arrayOthersStudiesRequired = explode(' ', $othersStudiesRequired);
                $missingCounter = 0;
                
                foreach($arrayOthersStudiesRequired as $otherStudie){
    
                    $checkIfExistDiplomeWithId = $this->getDoctrine()->getRepository(StudiesCharacters::class)->findByStudyAndStatus($otherStudie, $characterToEdit);
    
                    if(empty($checkIfExistDiplomeWithId)){
                        $missingCounter++;
                    }
    
                } 
                
                if($missingCounter > 0){
                    $this->addFlash('error', 'Il te manque un/des diplômes pour faire cette formation');
                    return $this->redirectToRoute('jeu_formationCenter');
                }
            }

            $studiesCounter = 0;

            foreach($characterToEdit->getStudies() as $study){
                // Status à zéro correspond à des études en cours
                if($study->getStatus() == 0){
                    $studiesCounter++;
                }
            }

            if($studiesCounter > 0){
                $this->addFlash('error', 'Tu as déjà une formation en cours !');
                return $this->redirectToRoute('jeu_formationCenter');
            }

            switch($mode){
                case 'withoutProf':
                    $formationCenterTemplate->GetInsertionTemplate($characterToEdit, $studies, $mode);
                    break;
                case 'withProf':
                    $this->addFlash('error', 'Formation avec professeur non opérationnelle');
                    return $this->redirectToRoute('jeu_formationCenter');
                    break;
                case 'vip':
                    $formationCenterTemplate->GetInsertionTemplate($characterToEdit, $studies, $mode);
                    break;
                default;
                    $this->addFlash('error', 'Erreur formation, contactez un administrateur.');
                    return $this->redirectToRoute('jeu_formationCenter');
            }
    
            $this->addFlash('success', 'Félicitations pour ta nouvelle formation !');
            return $this->redirectToRoute('jeu_formationCenter');

        }

    }

    /**
     * @Route("/jeu/centre_de_formation/leave/{id}", name="jeu_formationCenter_leave")
     */
    public function leaveFormation(Security $security, StudiesCharacters $study)
    {
        $character = $security->getUser()->getCharacters();
        $em = $this->getDoctrine()->getManager();

        if($character->getId() == $study->getCharacters()->getId()){
            $em->remove($study);
            $em->flush();
            $this->addFlash('success', 'Formation annulée avec succès');
            return $this->redirectToRoute('jeu_studies');
        }else{
            $this->addFlash('error', 'Tu n\'est pas autorisé à faire ça');
            return $this->redirectToRoute('jeu_studies');
        }
        
    }
    

}
