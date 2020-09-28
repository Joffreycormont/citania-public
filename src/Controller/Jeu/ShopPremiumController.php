<?php

namespace App\Controller\Jeu;

use App\Service\stripeShopTemplate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;



class ShopPremiumController extends AbstractController
{

    /**
     * @Route("/jeu/premium", name="jeu_premium")
     */
    public function premium(Security $security, Request $request)
    {

        return $this->render('jeu/home_game/premium.html.twig', [
            'controller_name' => 'HomeGameController'
        ]);
    }

    /**
     * @Route("/jeu/premium/valid", name="jeu_premium_payement_valid")
     */
    public function payementValid(Security $security, Request $request, stripeShopTemplate $stripeShopTemplate)
    {
        $user = $security->getUser();
        $character = $security->getUser()->getCharacters();
        
        if($request->query->get('product') != null){
            $product = $request->query->get('product');
        }else{
            return $this->redirectToRoute('jeu_premium');
        }
        // 

        \Stripe\Stripe::setApiKey($_ENV['STRIPE_SK_KEY']);

        define('STRIPE_SESSION_ID', $request->query->get('session_id'));

        if(constant('STRIPE_SESSION_ID') != null){
            $stripeSessionId = constant('STRIPE_SESSION_ID');

            try {
                \Stripe\Checkout\Session::retrieve($stripeSessionId);
              } catch (\Stripe\Exception\ApiErrorException $e) {
                return $this->redirectToRoute('jeu_premium');
              }
        
            $stripeSession = \Stripe\Checkout\Session::retrieve($stripeSessionId);
        
            $payementIntent = \Stripe\PaymentIntent::retrieve(
                $stripeSession['payment_intent']
              );
        
            if($payementIntent['status'] == "succeeded"){

                switch($product){
                    case 25:
                        $stripeShopTemplate->getInsertionTemplate($user, $character, $product, 2.99);
                        break;
                    case 50:
                        $stripeShopTemplate->getInsertionTemplate($user, $character, $product, 4.99);
                        break;
                    case 100:
                        $stripeShopTemplate->getInsertionTemplate($user, $character, $product, 9.99);
                        break;
                    case 150:
                        $stripeShopTemplate->getInsertionTemplate($user, $character, $product, 15.99);
                        break;
                    case 180:
                        $stripeShopTemplate->getInsertionTemplate($user, $character, $product, 19.99);
                        break;
                    case 260:
                        $stripeShopTemplate->getInsertionTemplate($user, $character, $product, 29.99);
                        break;
                    case 520:
                        $stripeShopTemplate->getInsertionTemplate($user, $character, $product, 49.99);
                        break;                        
                    case 1500:
                        $stripeShopTemplate->getInsertionTemplate($user, $character, $product, 99.99);
                        break;
                    default:
                        return $this->redirectToRoute('jeu_premium');
                    break;
                }
        
                $this->addFlash('success', 'Paiement effectué, merci pour ton achat et bon jeu !');
        
                return $this->redirectToRoute('jeu_premium');
        
            }else{
                return $this->redirectToRoute('jeu_premium');
            }
        }  
    }

    /**
     * @Route("/jeu/premium/cancel", name="jeu_premium_payement_cancel")
     */
    public function payementCancel()
    {
        $this->addFlash('error', 'Paiement annulé');
        return $this->redirectToRoute('jeu_premium');
    }

}
