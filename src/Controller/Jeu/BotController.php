<?php

namespace App\Controller\Jeu;

use App\Entity\HouseFurniture;
use App\Entity\ObjectCharacter;
use App\Entity\ObjectEffect;
use App\Entity\Product;
use App\Entity\StockCategory;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class BotController extends AbstractController
{
    /**
     * @Route("/jeu/robot/commercant", name="jeu_bot_shop")
     */
    public function shop()
    {
        $productList = $this->getDoctrine()->getRepository(Product::class)->findAll();

        return $this->render('jeu/bot/shop.html.twig', [
            'controller_name' => 'HomeGameController',
            'productList' => $productList
        ]);
        
    }

    /**
     * @Route("/jeu/robot/commercant/buy", name="jeu_bot_shop_buy", methods={"POST"})
     */
    public function shopBuy(Security $security, Request $request)
    {
        $character = $security->getUser()->getCharacters();
        $characterMoney = $character->getMoney();
        $characterId = $character->getId();
        $em = $this->getDoctrine()->getManager();

        $quantity = $request->request->get('quantity');
        $product = $request->request->get('product');
        $price = $request->request->get('price');
        $slug = $request->request->get('slug');

        $checkProductPrice = $this->getDoctrine()->getRepository(Product::class)->findBy(['name' => $product]);

        if(!empty($checkProductPrice)){
            if($checkProductPrice[0]->getPrice() != $price){
                $this->addFlash('error', 'hop hop hop tu essayes de faire le malin là :p');
                return $this->redirectToRoute('jeu_bot_shop');
            }
        }

        $checkIfObjectAlreadyExist = $this->getDoctrine()->getRepository(ObjectCharacter::class)->checkIfObjectAlreadyExist($characterId, $product);

        if(count($checkIfObjectAlreadyExist) > 0){
            $checkIfObjectAlreadyExist[0]->setQuantity($checkIfObjectAlreadyExist[0]->getQuantity() + $quantity);
            $em->persist($checkIfObjectAlreadyExist[0]);
        }else{
            $stockCategory = $this->getDoctrine()->getRepository(StockCategory::class)->find(1);

            $ObjectEffect = $this->getDoctrine()->getRepository(ObjectEffect::class)->findByProductName($product);

            $newObjectCharacter = new ObjectCharacter();
            $newObjectCharacter->setStockCategory($stockCategory);
            $newObjectCharacter->setCharacters($character);
            $newObjectCharacter->setName($product);
            $newObjectCharacter->setSlug($slug);
            $newObjectCharacter->setQuantity($quantity);

            if(empty($ObjectEffect) || $ObjectEffect == null){
                $this->addFlash('error', 'Erreur au niveau de l\'achat, contactez l\'administration');
                return $this->redirectToRoute('jeu_bot_shop');
            }else{
                $newObjectCharacter->setObjectEffect($ObjectEffect[0]);
            }

            $em->persist($newObjectCharacter);
        }

        $priceOperation = $characterMoney - ($quantity * $price);

        if($characterMoney > 0 && $priceOperation >= 0){
            $character->setMoney($priceOperation);
            $em->persist($character);
        }else{
            $this->addFlash('error', 'Tu n\'a pas assez d\'argent pour acheter ces produits');
            return $this->redirectToRoute('jeu_bot_shop');
        }

        $em->flush();

        $this->addFlash('success', 'Produit(s) acheté(s) et stocké(s) dans votre frigo !');
        return $this->redirectToRoute('jeu_bot_shop');
        
    }

}