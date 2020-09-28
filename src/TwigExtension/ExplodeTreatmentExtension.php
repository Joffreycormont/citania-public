<?php
// src/TwigExtension/ShuffleExtension.php
namespace App\TwigExtension;

use App\Entity\Treatment;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ExplodeTreatmentExtension extends AbstractExtension
{

    private $em = "";

    public function __construct(EntityManagerInterface $manager)
    {
        $this->em = $manager;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('explodeTreatment', [$this, 'explodeTreatment']),
        ];
    }

    public function explodeTreatment($treatmentIdsString)
    {

        $newTreatmentArray = [];

        $arrayTreatmentIds = explode(' ', $treatmentIdsString);

        foreach($arrayTreatmentIds as $treatmentId){
            $newTreatmentArray[] = $this->em->getRepository(Treatment::class)->find($treatmentId);
        }

        return $newTreatmentArray;
    }
}