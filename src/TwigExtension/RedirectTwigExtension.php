<?php
// src/TwigExtension/ShuffleExtension.php
namespace App\TwigExtension;

use App\Entity\Treatment;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RedirectTwigExtension extends AbstractExtension
{

    private $em = "";

    public function __construct(EntityManagerInterface $manager)
    {
        $this->em = $manager;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('redirect', [$this, 'redirect']),
        ];
    }

    public function redirect()
    {
        return $this->redirectToRoute('home');
    }
}