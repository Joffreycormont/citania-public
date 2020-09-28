<?php
namespace App\Service;

use App\Entity\CommandPremium;
use App\Entity\Logbook;
use Doctrine\ORM\EntityManagerInterface;

class stripeShopTemplate
{

    private $em;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getInsertionTemplate($user, $character, $product, $price)
    {
        $character->setDiamond($character->getDiamond() + $product);
        // insertion d'une nouvelle entrée pour le journal de bord du receveur
        $newLogbookEntry = new Logbook();
        $newLogbookEntry->setCharacters($character);
        $newLogbookEntry->setSend($character);
        $newLogbookEntry->setEvent('Premium');
        $newLogbookEntry->setContent('Tu viens de reçevoir un virement de <strong>'.$product.' diamants</strong>, merci pour ton achat et bon jeu !');

        // insertion nouvelle commande
        $newCommandPremium = new CommandPremium();
        $newCommandPremium->setName('Achat de diamant');
        $newCommandPremium->setQuantity($product);
        $newCommandPremium->setPrice($price);
        $newCommandPremium->setUser($user);

        $this->em->persist($character);
        $this->em->persist($newCommandPremium);
        $this->em->persist($newLogbookEntry);
        $this->em->flush();
    }
}