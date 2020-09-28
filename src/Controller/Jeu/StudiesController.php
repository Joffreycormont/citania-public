<?php

namespace App\Controller\Jeu;

use App\Entity\Studies;
use App\Entity\StudiesCharacters;
use App\Entity\StudiesTest;
use App\Entity\TestAnswers;
use App\Entity\TestQuestions;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class StudiesController extends AbstractController
{

    /**
     * @Route("/jeu/mes_etudes", name="jeu_studies")
     */
    public function myStudies(Security $security)
    {
        $character = $security->getUser()->getCharacters();

        $studiesList = $this->getDoctrine()->getRepository(StudiesCharacters::class)->findBy(array('Characters' => $character->getId()));

        // A CORRIGER
        $studiesListActive = $this->getDoctrine()->getRepository(StudiesCharacters::class)->findByCharacterAndStatus($character);

        return $this->render('jeu/studies/studies.html.twig', [
            'controller_name' => 'HomeGameController',
            'studiesList' => $studiesList,
            'studiesListActive' => $studiesListActive
        ]);
    }

    /**
     * @Route("/jeu/mes_etudes/mes_cours/formation/{id}", name="jeu_studies_lessons_withoutProf")
     */
    public function myLessons(Security $security, Studies $studie)
    {
        $character = $security->getUser()->getCharacters();

        $characterStudies = $character->getStudies();
        
        if(count($characterStudies) >= 1){
            foreach($characterStudies as $study){
                if($study->getStatus() == 0){
                    if($study->getStudy()->getId() != $studie->getId()){
                        $this->addFlash('error', 'Tu ne suis pas la bonne formation pour accéder à ces cours');
                        return $this->redirectToRoute('jeu_studies');
                    }
                }
            }
        }else{
            $this->addFlash('error', 'Tu ne suis pas de formation actuellement');
            return $this->redirectToRoute('jeu_studies');
        }

        return $this->render('jeu/studies/lessons.html.twig', [
            'controller_name' => 'HomeGameController',
            'studie' => $studie
        ]);
    }

    /**
     * @Route("/jeu/mes_etudes/examen/formation/{id}", name="jeu_studies_examen")
     */
    public function exam(Security $security, Studies $studie)
    {
        $character = $security->getUser()->getCharacters();

        $characterStudies = $character->getStudies();
        
        if(count($characterStudies) >= 1){
            foreach($characterStudies as $study){
                if($study->getStatus() == 0){
                    if($study->getStudy()->getId() != $studie->getId()){
                        $this->addFlash('error', 'Tu ne suis pas la bonne formation pour accéder a cet examen');
                        return $this->redirectToRoute('jeu_studies');
                    }
                }
            }
        }else{
            $this->addFlash('error', 'Tu ne suis pas de formation actuellement');
            return $this->redirectToRoute('jeu_studies');
        }

        $currentCharacterStudy = $this->getDoctrine()->getRepository(StudiesCharacters::class)->findByStudyAndStatusZero($studie, $character);

        if($currentCharacterStudy[0]->getDurationStatus() != $studie->getDuration()){
            $this->addFlash('error', 'Tu n\'as pas encore fini ta formation, il est trop tôt pour ton examen');
            return $this->redirectToRoute('jeu_studies');
        }


        $test = $studie->getStudiesTests();

        return $this->render('jeu/studies/exam.html.twig', [
            'controller_name' => 'HomeGameController',
            'studie' => $studie,
            'test' => $test[0]
        ]);
    }

    /**
     * @Route("/jeu/mes_etudes/examen/{id}/checkAnwsers", name="jeu_studies_examen_checkAnswers", methods={"POST"})
     */
    public function examCheckAnswers(Security $security, Request $request, StudiesTest $test)
    {
        $em = $this->getDoctrine()->getManager();
        $character = $security->getUser()->getCharacters();
        $TotalQuestions = count($test->getTestQuestions()); 
        $badAnswers = 0;
        $characterResponseArray = $request->request->all();
        $arrayQuestionWithMultiple = [];

        foreach(array_keys($characterResponseArray) as $value){
            $arrayQuestionWithMultiple += [explode('_', $value)[0].'_'.explode('_', $value)[1] => 0];
        }

        foreach($characterResponseArray as $responseKey => $responseValue){
            if(explode('_', $responseKey)[0] == "question"){
                $checkIfGoodAnswer = $this->getDoctrine()->getRepository(TestAnswers::class)->checkIfIsGoodAnswer($responseValue, explode('_', $responseKey)[1]);

                if(!$checkIfGoodAnswer){
                    $badAnswers++;
                }

            }elseif(explode('_', $responseKey)[0] == "questionWithMultiple"){

                $checkIfGoodAnswer = $this->getDoctrine()->getRepository(TestAnswers::class)->checkIfIsGoodAnswer($responseValue, explode('_', $responseKey)[1]);

                if($checkIfGoodAnswer != null){
                    $arrayQuestionWithMultiple["questionWithMultiple".'_'.explode('_', $responseKey)[1]]++;
                }else{
                    $arrayQuestionWithMultiple["questionWithMultiple".'_'.explode('_', $responseKey)[1]] += 10;
                }
            }
        }

        foreach($arrayQuestionWithMultiple as $key => $value){

            if(explode('_', $key)[0] == "questionWithMultiple"){

                $checkHowManyGoodAnswersRequired = $this->getDoctrine()->getRepository(TestAnswers::class)->checkHowManyGoodAnswersRequired(explode('_', $key)[1]);

                if($checkHowManyGoodAnswersRequired != $arrayQuestionWithMultiple["questionWithMultiple".'_'.explode('_', $key)[1]]){
                    $badAnswers++;
                }
            }
        }

        if(count($arrayQuestionWithMultiple) != $TotalQuestions){
            $this->addFlash('error', 'Vous devez répondre à toutes les questions');
            return $this->redirectToRoute('jeu_studies_examen', ['id' => $test->getStudy()->getId()]);
        }

        $successRate = 100 - (100 * $badAnswers) / $TotalQuestions;

        if($successRate < 50){

            $studiesListActive = $this->getDoctrine()->getRepository(StudiesCharacters::class)->findByStudyAndStatusZero($test->getStudy()->getId(), $character);
            $studiesListActive[0]->setDurationStatus($studiesListActive[0]->getDurationStatus() - 1);

            $em->persist($studiesListActive[0]);
            $em->flush();

            return $this->redirectToRoute('jeu_studies', ['examResult' => "Tu as un taux de réussite de ".round($successRate, 1)." % à ton examen, tu as donc échoué et tu pourra repasser ton examen dans un an (3 jours IRL)."]);

        }else{

            $studiesListActive = $this->getDoctrine()->getRepository(StudiesCharacters::class)->findByStudyAndStatusZero($test->getStudy()->getId(), $character);
            $studiesListActive[0]->setStatus(1);

            $em->persist($studiesListActive[0]);
            $em->flush();

            return $this->redirectToRoute('jeu_studies', ['examResult' => "Tu as un taux de réussite de ".round($successRate, 1)." %, tu as donc réussi ton examen, félicitations, tu va bientôt reçevoir ton diplôme !"]);
        }

    }



}
