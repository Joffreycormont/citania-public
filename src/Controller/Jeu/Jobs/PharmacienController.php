<?php

namespace App\Controller\Jeu\Jobs;

use App\Entity\Logbook;
use App\Entity\ObjectCharacter;
use App\Entity\ObjectEffect;
use App\Entity\Pharmacy;
use App\Entity\PharmacyDemands;
use App\Entity\PharmacyTreatmentStock;
use App\Entity\StockCategory;
use App\Entity\Treatment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class PharmacienController extends AbstractController
{


    /**
     * @Route("/jeu/mon_boulot/pharmacien/pharmacy/{pharmacy}/changeSalary", name="work_pharmacien_changeSalary", methods={"POST"})
     */
    public function changeSalary(Security $security, Request $request, Pharmacy $pharmacy)
    {
        $character = $security->getUser()->getCharacters();
        $em = $this->getDoctrine()->getManager();
        $newSalary = (int) $request->request->get('salary');

        if($pharmacy->getCharacters()->getId() == $character->getId()){

            if($newSalary > 1000){
                $this->addFlash('error', 'Montant du salaire maximum : 1000 €');
                $url = $this->generateUrl('jeu_work');
                return $this->redirect($url.'#jobAction');
            }elseif($newSalary < 0){
                $this->addFlash('error', 'Tu ne peux pas mettre un salaire négatif');
                $url = $this->generateUrl('jeu_work');
                return $this->redirect($url.'#jobAction');
            }

            $pharmacy->setOwnerSalary($newSalary);
            $em->persist($pharmacy);
            $em->flush();

            $this->addFlash('success', 'Salaire modifié avec succès');
            $url = $this->generateUrl('jeu_work');
            return $this->redirect($url.'#jobAction');
        }
    }


    /**
     * @Route("/jeu/mon_boulot/pharmacien/pharmacy/{pharmacy}/command/provider", name="work_pharmacien_commandProvider", methods={"POST"})
     */
    public function commandProvider(Security $security, Request $request, Pharmacy $pharmacy)
    {
        $character = $security->getUser()->getCharacters();
        $em = $this->getDoctrine()->getManager();
        $totalPriceCommand = 0;
        

        if($pharmacy->getCharacters()->getId() == $character->getId()){

            // verif if enough money in pharmacy
            foreach($request->request->all() as $key => $quantity){

                if($quantity > 0){
                    $treatment = $this->getDoctrine()->getRepository(Treatment::class)->find($key);
                    $totalPriceCommand += $treatment->getProviderPrice() * $quantity;
                }
            }

            if($totalPriceCommand > $pharmacy->getMoney()){
                $this->addFlash('error', 'Tu n\'as pas assez d\'argent pour toute la commande');
                $url = $this->generateUrl('jeu_work');
                return $this->redirect($url.'#jobAction');
            }


            foreach($request->request->all() as $key => $quantity){

                if($quantity < 0){
                    $this->addFlash('error', 'Tu ne peux pas acheter des produits en valeur négative');
                    $url = $this->generateUrl('jeu_work');
                    return $this->redirect($url.'#jobAction');
                }

                if($quantity > 0){
                    $treatment = $this->getDoctrine()->getRepository(Treatment::class)->find($key);
                    $checkIfStockExist = $this->getDoctrine()->getRepository(PharmacyTreatmentStock::class)->findByPharmacyAndTreatment($pharmacy, $treatment);

                    if($checkIfStockExist == null){

                        // new insertion in database
                        $newPharmacyStock = new PharmacyTreatmentStock();
                        $newPharmacyStock->setPharmacy($pharmacy);
                        $newPharmacyStock->setTreatment($treatment);
                        $newPharmacyStock->setStockQuantity($quantity);
                        $newPharmacyStock->setPrice($treatment->getPrice());

                        $pharmacy->setMoney($pharmacy->getMoney() - ( $treatment->getProviderPrice() * $quantity ));

                        $em->persist($newPharmacyStock);
                        $em->persist($pharmacy);

                    }else{
                        // edit existing
                        $stockToEdit = $checkIfStockExist[0];
                        $stockToEdit->setStockQuantity($stockToEdit->getStockQuantity() + $quantity);

                        $pharmacy->setMoney($pharmacy->getMoney() - ( $treatment->getProviderPrice() * $quantity ));

                        $em->persist($stockToEdit);
                        $em->persist($pharmacy);
                    }

                    $em->flush();
                }
            }
            $this->addFlash('success', 'Produit(s) acheté(s) avec succès');
            $url = $this->generateUrl('jeu_work');
            return $this->redirect($url.'#jobAction');
        }

    }

    /**
     * @Route("/jeu/mon_boulot/pharmacien/pharmacy/{pharmacy}/changePrice", name="work_pharmacien_changePrice", methods={"POST"})
     */
    public function changePrice(Security $security, Request $request, Pharmacy $pharmacy)
    {
        $character = $security->getUser()->getCharacters();
        $em = $this->getDoctrine()->getManager();
        $errorPriceCount = 0;

        if($pharmacy->getCharacters()->getId() == $character->getId()){

            foreach($request->request->all() as $key => $newTreatmentPrice){
                $treatment = $this->getDoctrine()->getRepository(Treatment::class)->find($key);

                if($newTreatmentPrice < $treatment->getProviderPrice()){
                    $errorPriceCount++;
                    $this->addFlash('error', 'Prix minimum pour '. $treatment->getName() .' : '.$treatment->getProviderPrice().' €');
                }elseif($newTreatmentPrice > $treatment->getPrice()){
                    $errorPriceCount++;
                    $this->addFlash('error', 'Prix maximum pour '. $treatment->getName() .' : '.$treatment->getPrice().' €');
                }
            }

            if($errorPriceCount > 0){
                $url = $this->generateUrl('jeu_work');
                return $this->redirect($url.'#jobAction');
            }

            foreach($request->request->all() as $key => $newTreatmentPrice){

                $treatment = $this->getDoctrine()->getRepository(Treatment::class)->find($key);

                $treatmentStock = $this->getDoctrine()->getRepository(PharmacyTreatmentStock::class)->findByPharmacyAndTreatment($pharmacy, $treatment);

                if($treatmentStock != null){
                    $treatmentStock[0]->setPrice($newTreatmentPrice);
                    $em->persist($treatmentStock[0]);
                }else{
                    $this->addFlash('error', 'Traitement inconnu, modification de prix impossible');
                    $url = $this->generateUrl('jeu_work');
                    return $this->redirect($url.'#jobAction');
                }

            }

            $em->flush();


            $this->addFlash('success', 'Prix modifié(s) avec succès');
            $url = $this->generateUrl('jeu_work');
            return $this->redirect($url.'#jobAction');
        }

    }


    /**
     * @Route("/jeu/mon_boulot/pharmacien/pharmacy/{id}/Demand", name="work_pharmacien_demandTreatment")
     */
    public function demandTreatment(Security $security, Request $request, Pharmacy $pharmacy)
    {
        $character = $security->getUser()->getCharacters();
        $em = $this->getDoctrine()->getManager();

        if($character->getTreatmentSubscription() != null){
            $newPharmacyDemand = new PharmacyDemands();
            $newPharmacyDemand->setPharmacy($pharmacy);
            $newPharmacyDemand->setCharacters($character);

            $em->persist($newPharmacyDemand);
            $em->flush();
        }

        $this->addFlash('success', 'Demande effectuée avec succès');
        return $this->redirectToRoute('jeu_work_visit', ['id' => $pharmacy->getCharacters()->getId()]);

    }   


    /**
     * @Route("/jeu/mon_boulot/pharmacien/pharmacy/acceptDemand/{id}", name="work_pharmacien_acceptDemand")
     */
    public function acceptDemand(Security $security, Request $request, PharmacyDemands $demand)
    {
        $character = $security->getUser()->getCharacters();
        $em = $this->getDoctrine()->getManager();
        $pharmacy = $demand->getPharmacy();
        $treatmentIds = $demand->getCharacters()->getTreatmentSubscription();
        $visitorCharacter = $demand->getCharacters();

        if($pharmacy->getCharacters()->getId() == $character->getId()){

            $treatmentsArray = explode(' ', $treatmentIds);

            foreach($treatmentsArray as $treatment){

                $checkIfStockExist = $this->getDoctrine()->getRepository(PharmacyTreatmentStock::class)->findByPharmacyAndTreatment($pharmacy, $treatment);

                if(!$checkIfStockExist){
                    $this->addFlash('error', 'Tu n\'as pas assez de stock pour tout les médicaments du patient');
                    $url = $this->generateUrl('jeu_work');
                    return $this->redirect($url.'#jobAction');
                }elseif($checkIfStockExist[0]->getStockQuantity() <= 0){
                    $this->addFlash('error', 'Tu n\'as pas assez de stock pour tout les médicaments du patient');
                    $url = $this->generateUrl('jeu_work');
                    return $this->redirect($url.'#jobAction');
                }

                $stockToEdit = $checkIfStockExist[0];
                $stockToEdit->setStockQuantity($checkIfStockExist[0]->getStockQuantity() - 1);

                
                $em->persist($stockToEdit);

                if($stockToEdit->getStockQuantity() == 0){
                    $em->remove($stockToEdit);
                }

                $stockCategory = $this->getDoctrine()->getRepository(StockCategory::class)->find(2);
                $ObjectEffect = $this->getDoctrine()->getRepository(ObjectEffect::class)->findByProductName("Treatment");

                $newObjectCharacter = new ObjectCharacter();
                $newObjectCharacter->setName($stockToEdit->getTreatment()->getName());
                $newObjectCharacter->setStockCategory($stockCategory);
                $newObjectCharacter->setCharacters($demand->getCharacters());
                $newObjectCharacter->setQuantity(1);
                $newObjectCharacter->setSlug('treatment');
                $newObjectCharacter->setObjectEffect($ObjectEffect[0]);
                
                $em->persist($newObjectCharacter);

                $pharmacy->setMoney($pharmacy->getMoney() + $stockToEdit->getPrice());

                $visitorCharacter->setMoney($visitorCharacter->getMoney() - $stockToEdit->getPrice());
                $visitorCharacter->setTreatmentTaken(2);

                $em->persist($pharmacy);
                $em->persist($visitorCharacter);

            }

            $newLogbookEntry = new Logbook();
            $newLogbookEntry->setCharacters($visitorCharacter);
            $newLogbookEntry->setSend($character);
            $newLogbookEntry->setEvent('Sante');
            $newLogbookEntry->setContent('Tu as reçu tes médicaments de la part du/ de la pharmacien(ne) <strong>'.$character->getFirstname().' '.$character->getLastname().'</strong>, ils sont dans l\'étagère de ta maison !');

            $em->persist($newLogbookEntry);

            $em->remove($demand);

            $em->flush();

            $this->addFlash('success', 'Traitement attribué/vendu avec succès');
            $url = $this->generateUrl('jeu_work');
            return $this->redirect($url.'#jobAction');
        }

    }

    /**
     * @Route("/jeu/mon_boulot/pharmacien/pharmacy/denyDemand/{id}", name="work_pharmacien_denyDemand")
     */
    public function denyDemand(Security $security, PharmacyDemands $demand)
    {
        $character = $security->getUser()->getCharacters();
        $em = $this->getDoctrine()->getManager();
        $pharmacy = $demand->getPharmacy();

        if($pharmacy->getCharacters()->getId() == $character->getId()){
            $em->remove($demand);

            $newLogbookEntry = new Logbook();
            $newLogbookEntry->setCharacters($demand->getCharacters());
            $newLogbookEntry->setSend($character);
            $newLogbookEntry->setEvent('Sante');
            $newLogbookEntry->setContent('Ta demande de traitement a été refusée par le/la pharmacien(ne) <strong>'.$character->getFirstname().' - '.$character->getLastname().'</strong>');

            $em->persist($newLogbookEntry);
            $em->flush();
            
            $this->addFlash('success', 'Demande refusée avec succès');
            $url = $this->generateUrl('jeu_work');
            return $this->redirect($url.'#jobAction');
        }
    }


    /**
     * @Route("/jeu/mon_boulot/pharmacien/pharmacy/cancelDemand/{id}", name="work_pharmacien_cancelDemand")
     */
    public function cancelDemandFromVisitor(Security $security, PharmacyDemands $demand)
    {
        $character = $security->getUser()->getCharacters();
        $em = $this->getDoctrine()->getManager();
        $pharmacyOwnerId = $demand->getPharmacy()->getCharacters()->getId();

        if($demand->getCharacters()->getId() == $character->getId()){

            $em->remove($demand);
            $em->flush();
            
            $this->addFlash('success', 'Demande annulée avec succès');
            return $this->redirectToRoute('jeu_work_visit', ['id' => $pharmacyOwnerId]);
        }

    }    


}
