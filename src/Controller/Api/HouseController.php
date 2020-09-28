<?php

namespace App\Controller\Api;

use App\Entity\ObjectCharacter;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HouseController extends AbstractController
{
    /**
     * @Route("/api/house/eat/{id}/{quantityToEat}", name="api_house_eat")
     */
    public function houseEat(ObjectCharacter $objectCharacter, Security $security, $quantityToEat)
    {

        $user = $security->getUser();
        if($user != null){

            $character = $user->getCharacters();
            $em = $this->getDoctrine()->getManager();

            // object effect
            $objectEffect = $objectCharacter->getObjectEffect();

            $life = $character->getLife();
            $food = $character->getFood();
            $water = $character->getWater();
            $sickness = $character->getSickness();
            $shape = $character->getShape();
            $cleanliness = $character->getCleanliness();
            $urine = $character->getUrine();
            $stools = $character->getStools();
            $waste = $character->getWaste();

            // gain
            $gainLife = $objectEffect->getLifeEffect();
            $gainFood = $objectEffect->getFoodEffect();
            $gainWater = $objectEffect->getWaterEffect();
            $gainSickness = $objectEffect->getSicknessEffect();
            $gainShape = $objectEffect->getShapeEffect();
            $gainCleanliness = $objectEffect->getCleanEffect();
            $gainUrine = $objectEffect->getUrineEffect();
            $gainStools = $objectEffect->getStoolsEffect();
            $gainWaste = $objectEffect->getWasteEffect();

            // loose
            $looseLife = $objectEffect->getLooseLifeEffect();
            $looseFood = $objectEffect->getLooseFoodEffect();
            $looseWater = $objectEffect->getLooseWaterEffect();
            $looseSickness = $objectEffect->getLooseSicknessEffect();
            $looseShape = $objectEffect->getLooseShapeEffect();
            $looseCleanliness = $objectEffect->getLooseCleanEffect();
            $looseUrine = $objectEffect->getLooseUrineEffect();
            $looseStools = $objectEffect->getLooseStoolsEffect();
            $looseWaste = $objectEffect->getLooseWasteEffect();

            // Life

                // gain effect
                if($life < 100){
                    if($life + ($gainLife * $quantityToEat) > 100){
                        $life = 100;
                        $character->setLife(100);
                    }else{
                        $life += ($gainLife * $quantityToEat);
                        $character->setLife($life + ($gainLife * $quantityToEat));
                    }
                }

                //loose effect
                if($life > 0){
                    if($life - ($looseLife * $quantityToEat) < 0){
                        $character->setLife(0);
                    }else{
                        $character->setLife($life - ($looseLife * $quantityToEat));
                    }
                }

            // Food

                // gain effect
                if($food < 100){
                    if($food + $gainFood * $quantityToEat > 100){
                        $food = 100;
                        $character->setFood(100);
                    }else{
                        $food += $gainFood * $quantityToEat;
                        $character->setFood($food + $gainFood * $quantityToEat);
                    }
                }

                //loose effect
                if($food > 0){
                    if($food - $looseFood * $quantityToEat < 0){
                        $character->setFood(0);
                    }else{
                        $character->setFood($food - $looseFood * $quantityToEat);
                    }
                }

            // Water

                // gain effect
                if($water < 100){
                    if($water + $gainWater * $quantityToEat > 100){
                        $water = 100;
                        $character->setWater(100);
                    }else{
                        $water += $gainWater * $quantityToEat;
                        $character->setWater($water + $gainWater * $quantityToEat);
                    }
                }

                //loose effect
                if($water > 0){
                    if($water - $looseWater * $quantityToEat < 0){
                        $character->setWater(0);
                    }else{
                        $character->setWater($water - $looseWater * $quantityToEat);
                    }
                }

            // Sickness

                // gain effect
                if($sickness < 100){
                    if($sickness + $gainSickness * $quantityToEat > 100){
                        $sickness = 100;
                        $character->setSickness(100);
                    }else{
                        $sickness += $gainSickness * $quantityToEat;
                        $character->setSickness($sickness + $gainSickness * $quantityToEat);
                    }
                }

                //loose effect
                if($sickness > 0){
                    if($sickness - $looseSickness * $quantityToEat < 0){
                        $character->setSickness(0);
                    }else{
                        $character->setSickness($sickness - $looseSickness * $quantityToEat);
                    }
                }

            // Shape

                // gain effect
                if($shape < 100){
                    if($shape + $gainShape * $quantityToEat > 100){
                        $shape = 100;
                        $character->setShape(100);
                    }else{
                        $shape += $gainShape * $quantityToEat;
                        $character->setShape($shape + $gainShape * $quantityToEat);
                    }
                }

                //loose effect
                if($shape > 0){
                    if($shape - $looseShape * $quantityToEat < 0){
                        $character->setShape(0);
                    }else{
                        $character->setShape($shape - $looseShape * $quantityToEat);
                    }
                }

            // Cleanliness

                // gain effect
                if($cleanliness < 100){
                    if($cleanliness + $gainCleanliness * $quantityToEat > 100){
                        $cleanliness = 100;
                        $character->setCleanliness(100);
                    }else{
                        $cleanliness += $gainCleanliness * $quantityToEat;
                        $character->setCleanliness($cleanliness + $gainCleanliness * $quantityToEat);
                    }
                }

                //loose effect
                if($cleanliness > 0){
                    if($cleanliness - $looseCleanliness * $quantityToEat < 0){
                        $character->setCleanliness(0);
                    }else{
                        $character->setCleanliness($cleanliness - $looseCleanliness * $quantityToEat);
                    }
                }

            // Urine

                // gain effect
                if($urine < 100){
                    if($urine + $gainUrine * $quantityToEat > 100){
                        $urine = 100;
                        $character->setUrine(100);
                    }else{
                        $urine += $gainUrine * $quantityToEat;
                        $character->setUrine($urine + $gainUrine * $quantityToEat);
                    }
                }

                //loose effect
                if($urine > 0){
                    if($urine - $looseUrine * $quantityToEat < 0){
                        $character->setUrine(0);
                    }else{
                        $character->setUrine($urine - $looseUrine * $quantityToEat);
                    }
                }

            //Stools

                // gain effect
                if($stools < 100){
                    if($stools + $gainStools * $quantityToEat > 100){
                        $stools = 100;
                        $character->setStools(100);
                    }else{
                        $stools += $gainStools * $quantityToEat;
                        $character->setStools($stools + $gainStools * $quantityToEat);
                    }
                }

                //loose effect
                if($stools > 0){
                    if($stools - $looseStools * $quantityToEat < 0){
                        $character->setStools(0);
                    }else{
                        $character->setStools($stools - $looseStools * $quantityToEat);
                    }
                }

            //Waste

                // gain effect
                $waste += $gainWaste * $quantityToEat;
                $character->setWaste($waste + $gainWaste * $quantityToEat);

                //loose effect
                if($waste > 0){
                    if($waste - $looseWaste * $quantityToEat < 0){
                        $character->setWaste(0);
                    }else{
                        $character->setWaste($waste - $looseWaste * $quantityToEat);
                    }
                }

            if($objectCharacter->getSlug() == "treatment"){
                $treatmentSubscription = $character->getTreatmentSubscription();

                $arraySubscription = explode(' ',$treatmentSubscription);
                array_pop($arraySubscription);
                $character->setTreatmentSubscription(implode(' ', $arraySubscription));

                $em->persist($character);

                if(empty($character->getTreatmentSubscription())){
                    $character->setTreatmentSubscription(null);
                    $character->setLife(100);
                    $character->setSickness(0);
                    $character->setTreatmentTaken(3);

                    $diseasesCharacter = $character->getDiseaseCharacters();

                    foreach($diseasesCharacter as $disease){
                        $em->remove($disease);
                    }

                }

            }

            $newQuantity = $objectCharacter->getQuantity() - $quantityToEat;
            $objectCharacter->setQuantity($newQuantity);

            if($newQuantity < 1){
                $em->remove($objectCharacter);
                $em->flush();
                return $this->json('Objet utilisé');
                exit;
            }

            $em->persist($objectCharacter);
            $em->persist($character);
            $em->flush();

            return $this->json('Objet utilisé');
        }else{
            return $this->json('Vous êtes déconnecté, rafraîchissez la page !');
        }

    }
}
