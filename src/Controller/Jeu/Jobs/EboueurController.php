<?php

namespace App\Controller\Jeu\Jobs;


use App\Entity\Logbook;
use App\Entity\TruckWaste;
use App\Entity\WasteToTake;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class EboueurController extends AbstractController
{
    /**
     * @Route("/jeu/mon_boulot/eboueur/valid/{id}", name="work_eboueur_validWaste")
     */
    public function validWaste(Security $security, WasteToTake $waste)
    {
        $user = $security->getuser()->getCharacters();
        $wasteRequestToValid = $this->getDoctrine()->getRepository(WasteToTake::class)->find($waste->getId());


        if($wasteRequestToValid){

            if($user->getTruckWaste()->getCapacity() < 2500){

                $concernedUser = $waste->getCharacters();
                $concernedUser->setWaste($concernedUser->getWaste() - $wasteRequestToValid->getWeight());
                $concernedUser->setWasteToTake(null);
    
                // insertion d'une nouvelle entrée pour le journal de bord du receveur
                $newLogbookEntry = new Logbook();
                $newLogbookEntry->setCharacters($concernedUser);
                $newLogbookEntry->setSend($user);
                $newLogbookEntry->setEvent('Services');
                $newLogbookEntry->setContent('Tes poubelles ont été ramassées par '.$user->getFirstname().' '.$user->getLastname());

                $truckToUpdate = $user->getTruckWaste();
                $truckToUpdate->setCapacity($truckToUpdate->getCapacity() + $waste->getWeight());
    
                $em = $this->getDoctrine()->getManager();
                $em->persist($concernedUser);
                $em->persist($newLogbookEntry);
                $em->persist($truckToUpdate);
                $em->remove($waste);
                $em->flush();
    
                $this->addFlash('success', 'Ramassage des poubelles effectué');

                $url = $this->generateUrl('jeu_work');
                return $this->redirect($url.'#jobAction');
            }else{
                $this->addFlash('error', 'Tu n\'as plus de place dans ton camion du doit aller à la déchetterie');
                return $this->redirectToRoute('jeu_work');
            }

        }else{
            $this->addFlash('error', 'Un autre eboueur a été plus rapide que toi');
            return $this->redirectToRoute('jeu_work');
        }

        return $this->render('jeu/jobs/eboueurWork.html.twig', [
            'controller_name' => 'HomeGameController'
        ]);

        
    }

        /**
     * @Route("/jeu/mon_boulot/eboueur/wasteCollection/truck/{id}", name="work_eboueur_wasteCollection")
     */
    public function WasteCollection(Security $security, TruckWaste $truck)
    {
        $user = $security->getuser()->getCharacters();

        if($user->getId() == $truck->getCharacters()->getId()){

            if($truck->getCapacity() < 250){
                $this->addFlash('error', 'Il te faut un minimum de 250 kg pour faire un dépôt à la déchetterie');
                return $this->redirectToRoute('jeu_work');
            }

            $prime = "";

            switch(true){
                case $truck->getCapacity() > 250 && $truck->getCapacity() < 500:
                    // bonus de € pour avoir rempli le camion et l'avoir vider
                    $prime = 35;
                    $user->setMoney($user->getMoney() + $prime);
                    break; 
                case $truck->getCapacity() > 500 && $truck->getCapacity() < 1000:
                    $prime = 70;
                    $user->setMoney($user->getMoney() + $prime);
                    break; 
                case $truck->getCapacity() > 1000 && $truck->getCapacity() < 1750:
                    $prime = 100;
                    $user->setMoney($user->getMoney() + $prime);
                    break;
                case $truck->getCapacity() > 1750 && $truck->getCapacity() < 2000:
                    $prime = 175;
                    $user->setMoney($user->getMoney() + $prime);
                    break;
                case $truck->getCapacity() > 2000 && $truck->getCapacity() < 2500:
                    $prime = 195;
                    $user->setMoney($user->getMoney() + $prime);
                    break;    
                case $truck->getCapacity() >= 2500:
                    $prime = 225;
                    $user->setMoney($user->getMoney() + $prime);
                    break;
                default:
            }
            $truck->setCapacity(0);

            // insertion d'une nouvelle entrée pour le journal de bord du receveur
            $newLogbookEntry = new Logbook();
            $newLogbookEntry->setCharacters($user);
            $newLogbookEntry->setSend($user);
            $newLogbookEntry->setEvent('Bonus');
            $newLogbookEntry->setContent('Tu as reçu une prime de '.$prime.' € pour avoir vider ton camion à la déchetterie ');

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->persist($truck);
            $em->persist($newLogbookEntry);
            $em->flush();

            $this->addFlash('success', 'Vidange du camion effectué');
            $url = $this->generateUrl('jeu_work');
            return $this->redirect($url.'#jobAction');
        }
    }


}
