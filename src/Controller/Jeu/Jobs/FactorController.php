<?php

namespace App\Controller\Jeu\Jobs;

use App\Entity\FactorPrimes;
use App\Entity\GlobalGameVariable;
use App\Entity\Logbook;
use App\Entity\Messages;
use App\Entity\StampStock;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class FactorController extends AbstractController
{
    /**
     * @Route("/jeu/mon_boulot/facteur/acceptLetter/{id}", name="work_factor_acceptLetter")
     */
    public function acceptLetter(Security $security, Messages $message)
    {
        $character = $security->getUser()->getCharacters();
        $factorPrimes = $this->getDoctrine()->getRepository(FactorPrimes::class)->findAll();
        $stampStock = $this->getDoctrine()->getRepository(StampStock::class)->findBy(['characters' => $character])[0];

        if($character->getJob()->getSlug() == "facteur"){
            $message->setStatus(1);

            $stampStock->setPostedLetter($stampStock->getPostedLetter() + 1);

            foreach($factorPrimes as $prime){
                if($prime->getNumberToReach() == $stampStock->getPostedLetter()){
                    $character->setMoney($character->getMoney() + $prime->getPrice());
                }
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($stampStock);
            $em->persist($message);
            $em->flush();

            $this->addFlash('success', 'Lettre postée avec succès');
            return $this->redirectToRoute('jeu_work');
        }

    }

    /**
     * @Route("/jeu/mon_boulot/facteur/commandProvider", name="work_factor_commandProvider")
     */
    public function commandProvider(Security $security, Request $request)
    {
        $character = $security->getUser()->getCharacters();
        $quantity = (is_float($request->request->get('quantity')) || is_numeric($request->request->get('quantity'))) ? $request->request->get('quantity') : 0;
        $governmentMoney = $this->getDoctrine()->getRepository(GlobalGameVariable::class)->findBy(['name' => 'GOVERNMENT_MONEY'])[0];

        if($quantity > 99 || $quantity < 0){
            $this->addFlash('error', 'Quantité invalide, doit se trouver entre 0 et 99');
            return $this->redirectToRoute('jeu_work');
        }

        if($character->getJob()->getSlug() == "facteur"){

            $stockToEdit = $this->getDoctrine()->getRepository(StampStock::class)->findBy(['characters' => $character])[0];

            if($stockToEdit->getQuantity() + $quantity > 200){
                $this->addFlash('error', 'Commande invalide, tu n\'as pas assez de place dans ton bureau');
                return $this->redirectToRoute('jeu_work');
            }

            $stockToEdit->setQuantity($stockToEdit->getQuantity() + $quantity);
            $governmentMoney->setValue($governmentMoney->getValue() - ($quantity * 0.50));

            $em = $this->getDoctrine()->getManager();
            $em->persist($stockToEdit);
            $em->persist($governmentMoney);
            $em->flush();

            $this->addFlash('success', 'Commande effectuée avec succès');
            return $this->redirectToRoute('jeu_work');
        }

    }

    /**
     * @Route("/jeu/mon_boulot/facteur/changePrice", name="work_factor_changePrice", methods={"POST"})
     */
    public function changePrice(Security $security, Request $request)
    {
        $character = $security->getUser()->getCharacters();
        $price = floatval((is_float($request->request->get('price')) || is_numeric($request->request->get('price'))) ? $request->request->get('price') : 0);

        if($price > 1 || $price < 0.55){
            $this->addFlash('error', 'prix invalide, doit se trouver entre 0.55 € et 1 €');
            return $this->redirectToRoute('jeu_work');
        }

        if($character->getJob()->getSlug() == "facteur"){

            $stockToEdit = $this->getDoctrine()->getRepository(StampStock::class)->findBy(['characters' => $character])[0];
            $stockToEdit->setPrice($price);

            $em = $this->getDoctrine()->getManager();
            $em->persist($stockToEdit);
            $em->flush();

            $this->addFlash('success', 'Changement de prix effectué');
            return $this->redirectToRoute('jeu_work');
        }

    }


    /**
     * @Route("/jeu/mon_boulot/facteur/buyStamp/{id}", name="work_factor_buyStamp", methods={"POST"})
     */
    public function buyStamp(Security $security, Request $request, StampStock $stock)
    {
        $character = $security->getUser()->getCharacters();
        $quantity = floatval((is_float($request->request->get('quantity')) || is_numeric($request->request->get('quantity'))) ? $request->request->get('quantity') : 0);
        $governmentMoney = $this->getDoctrine()->getRepository(GlobalGameVariable::class)->findBy(['name' => 'GOVERNMENT_MONEY'])[0];

        if($quantity > 99 || $quantity < 0){
            $this->addFlash('error', 'quantité invalide, doit se trouver entre 0 et 99');
            return $this->redirectToRoute('jeu_work_visit', ['id' => $stock->getCharacters()->getId()]);
        }

        if($stock->getCharacters()->getJob()->getSlug() == "facteur"){

            if(($stock->getQuantity() - $quantity) < 0){
                $this->addFlash('error', 'Ce facteur n\'as pas assez de stock pour en acheter autant');
                return $this->redirectToRoute('jeu_work_visit', ['id' => $stock->getCharacters()->getId()]);
            }

            $stock->setQuantity($stock->getQuantity() - $quantity);

            $character->setStamps($character->getStamps() + $quantity);
            $character->setMoney($character->getMoney() - ($stock->getPrice() * $quantity));

            $governmentMoney->setValue($governmentMoney->getValue() + ($stock->getPrice() * $quantity));

            $em = $this->getDoctrine()->getManager();

            $em->persist($character);
            $em->persist($governmentMoney);
            $em->persist($stock);
            $em->flush();

            $this->addFlash('success', 'Achat de timbre effectué');
            return $this->redirectToRoute('jeu_work_visit', ['id' => $stock->getCharacters()->getId()]);
        }

    }  


}
