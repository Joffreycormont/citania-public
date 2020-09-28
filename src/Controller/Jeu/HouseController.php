<?php

namespace App\Controller\Jeu;

use App\Entity\HouseFurniture;
use App\Entity\Jobs;
use App\Entity\ObjectCharacter;
use App\Entity\WasteToTake;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HouseController extends AbstractController
{
    /**
     * @Route("/jeu/ma_maison", name="jeu_house")
     */
    public function index(Security $security)
    {

        $user = $security->getUser()->getCharacters();
        $userHouse = $user->getHouse();



        $houseFurnitureList = $this->getDoctrine()->getRepository(HouseFurniture::class)->findByHouse($userHouse);
        //$objectList = $this->getDoctrine()->getRepository(ObjectCharacter::class)->findByUser();


        return $this->render('jeu/house/house.html.twig', [
            'controller_name' => 'HomeGameController',
            'houseFurnitures' => $houseFurnitureList
        ]);
        
    }

        /**
     * @Route("/jeu/profil/trashOut", name="jeu_profil_trashOut")
     */
    public function trashOut(Security $security)
    {
        $user = $security->getUser();
        $userCharacter = $user->getCharacters();

        $weight = $userCharacter->getWaste();

        if($weight > 0){
            $checkWasteRequest = $this->getDoctrine()->getRepository(WasteToTake::class)->checkWasteRequest($userCharacter);

            if(count($checkWasteRequest) == 0){
    
                $wasteToTake = new WasteToTake();
                $wasteToTake->setWeight($weight);
                $wasteToTake->setCharacters($userCharacter);
    
    
                $em = $this->getDoctrine()->getManager();
                $em->persist($wasteToTake);
                $em->flush();
    
                $this->addFlash('success', 'Vos poubelles sont sorties');
                return $this->redirectToRoute('jeu_house');
            
            }else{
                $this->addFlash('error', 'Vous avez déjà sorti vos poubelles, attendez le passage des eboueurs');
                return $this->redirectToRoute('jeu_house');
            }
        }else{
            $this->addFlash('error', 'Vous ne pouvez pas sortir vos poubelles si elles sont vides');
            return $this->redirectToRoute('jeu_house');
        }

    }


    /**
     * @Route("/jeu/profil/go/toilet", name="jeu_profil_toilet")
     */
     public function goToilet(Security $security)
     {
        $user = $security->getUser()->getCharacters();

        if($user->getUrine() == 0 && $user->getStools() == 0 ){
            $this->addFlash('warning', 'Pas besoin d\'aller aux toilettes tes jauges sont déjà vides');
            return $this->redirectToRoute('jeu_house');
        }

        $UrineStools = $user->getUrine() + $user->getStools();

        $user->setUrine(0);
        $user->setStools(0);
        

        switch(true){
            case $UrineStools > 50:
                $user->setWaste($user->getWaste() + 30);
                break;
            case $UrineStools > 40:
                $user->setWaste($user->getWaste() + 20);
                break;
            case $UrineStools > 30:
                $user->setWaste($user->getWaste() + 10);
                break;
            case $UrineStools > 20:
                $user->setWaste($user->getWaste() + 8);
                break;
            case $UrineStools > 10:
                $user->setWaste($user->getWaste() + 4);
                break;
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $this->addFlash('success', 'Action effectuée');
        return $this->redirectToRoute('jeu_house');
     }


         /**
     * @Route("/jeu/profil/takeShower", name="jeu_profil_takeShower")
     */
    public function takeShower(Security $security)
    {
       $user = $security->getUser()->getCharacters();

       if($user->getCleanliness() == 100){
           $this->addFlash('warning', 'Tu es déjà tout propre');
           return $this->redirectToRoute('jeu_house');
       }

       $UrineStools = $user->getUrine() + $user->getStools();

       $user->setCleanliness(100);

       $em = $this->getDoctrine()->getManager();
       $em->persist($user);
       $em->flush();

       $this->addFlash('success', 'Douche prise');
       return $this->redirectToRoute('jeu_house');
    }

}