<?php

namespace App\Command;

use App\Entity\Characters;
use App\Entity\DiseaseCharacter;
use App\Entity\Diseases;
use App\Entity\HasAction;
use App\Entity\Logbook;
use App\Entity\Patient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;

class DailyUpdateCommand extends Command
{
    protected static $defaultName = 'dailyUpdate';

    private $security;
    private $em;

    public function __construct(Security $security, EntityManagerInterface $em)
    {
        $this->security = $security;
        $this->em = $em;
        // you *must* call the parent constructor
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        //setting

        // Reset of table has_action
        $hasActionList = $this->em->getRepository(HasAction::class)->findAll();

        foreach($hasActionList as $actionToDelete){
            $this->em->remove($actionToDelete);
        }







        // handle character informations
        $charactersList = $this->em->getRepository(Characters::class)->findAll();

        foreach($charactersList as $character){

                    // jauges de santé
            $looseLife = 1;
            $looseFood = 25;
            $looseWater = 32;
            $looseShape = 6;
            $looseCleanliness = 15;
            $gainSickness = 0;
            $gainUrine = 20;
            $gainStools = 20;

            $life = $character->getLife();
            $food = $character->getFood();
            $water = $character->getWater();
            $sickness = $character->getSickness();
            $shape = $character->getShape();
            $cleanliness = $character->getCleanliness();
            $urine = $character->getUrine();
            $stools = $character->getStools();

            $jaugesArray = [
                $food,$water,$shape,$cleanliness
            ];

            $naturalNeedArray = [
                $urine,$stools
            ];
            
            //update life + sickness
            if($life > 0){
                if($life - $looseLife < 0){
                    $character->setLife(0);
                }else{

                    foreach($jaugesArray as $jauge){

                        switch(true){
                            case $jauge < 15:
                                $looseLife += 3;
                                $gainSickness += 3;
                                break;
                            case $jauge < 30:
                                $looseLife += 2;
                                $gainSickness += 2;
                                break;                   
                            case $jauge < 50:
                                $looseLife += 1;
                                $gainSickness += 1;
                                break;                           
                        }

                    }

                    foreach($naturalNeedArray as $jauge){

                        switch(true){
                            case $jauge > 90:
                                $looseLife += 3;
                                $gainSickness += 4;
                                break;
                            case $jauge > 70:
                                $looseLife += 2;
                                $gainSickness += 3;
                                break;                   
                            case $jauge > 50:
                                $looseLife += 1;
                                $gainSickness += 2;
                                break;                           
                        }
                    }    
                    
                    if($life - $looseLife < 0){
                        $character->setLife(0);
                    }else{
                        $character->setLife($life - $looseLife);
                    }
                }
            }

            if($food > 0){
                if($food - $looseFood < 0){
                    $character->setFood(0);
                }else{
                    $character->setFood($food - $looseFood);
                }
            }

            if($water > 0){
                if($water - $looseWater < 0){
                    $character->setWater(0);
                }else{
                    $character->setWater($water - $looseWater);
                }
            }

            if($shape > 0){
                if($shape - $looseShape < 0){
                    $character->setShape(0);
                }else{
                    $character->setShape($shape - $looseShape);
                }
            }

            if($cleanliness > 0){
                if($cleanliness - $looseCleanliness < 0){
                    $character->setCleanliness(0);
                }else{
                    $character->setCleanliness($cleanliness - $looseCleanliness);
                }
            }

            if($urine < 100){
                if($urine + $gainUrine > 100){
                    $character->setUrine(100);
                }else{
                    $character->setUrine($urine + $gainUrine);
                }
            }

            if($stools < 100){
                if($stools + $gainStools > 100){
                    $character->setStools(100);
                }else{
                    $character->setStools($stools + $gainStools);
                }
            }

            if($sickness < 100){
                if($sickness + $gainSickness > 100){
                    $character->setSickness(100);
                }else{
                    $character->setSickness($sickness + $gainSickness);
                }
            }

            $sickness = $character->getSickness();

            $diseases = [];

            //get disease compared to gauge status
            switch(true){
                case ($sickness > 85):
                    $diseases = $this->em->getRepository(Diseases::class)->findByHardPlusAndOthers();
                    break;

                case ($sickness > 65):
                    $diseases = $this->em->getRepository(Diseases::class)->findByHardAndOthers();
                    break;

                case ($sickness > 45):
                    $diseases = $this->em->getRepository(Diseases::class)->findByMediumAndEasy();
                    break;

                case ($sickness > 35):
                    $diseases = $this->em->getRepository(Diseases::class)->findBy(["level" => "easy"]);
                    break;
                default:
            }

            if(!empty($diseases)){
                $newDisease = $diseases[array_rand($diseases, 1)];

                $checkIfAlreadyhaveDisease = $this->em->getRepository(DiseaseCharacter::class)->checkIfAlreadyhaveDisease($newDisease, $character);
    
                if(!$checkIfAlreadyhaveDisease){
                    $newDiseaseToCharacter = new DiseaseCharacter();
                    $newDiseaseToCharacter->setDisease($newDisease);
                    $newDiseaseToCharacter->setCharacters($character);
                    $newDiseaseToCharacter->setDiseaseDiscoverStatus(0);
        
                    $newLogbookEntryDisease = new Logbook();
                    $newLogbookEntryDisease->setCharacters($character);
                    $newLogbookEntryDisease->setSend($character);
                    $newLogbookEntryDisease->setEvent('Sante');
                    $newLogbookEntryDisease->setContent('Attention ! Tu es atteint d\'une maladie, tu dois consulter un médecin pour avoir un diagnostic');
        
                    $this->em->persist($newLogbookEntryDisease);
                    $this->em->persist($newDiseaseToCharacter);
                }
    
            }
            // reopen private window
            $character->setIsWindowOpen(1);


            // adding a year for active formations
            foreach($character->getStudies() as $study){

                $study->setYearStatus($study->getYearStatus() + 1);

                if($study->getYearStatus() == 3){
                    if(($study->getDurationStatus() + 1) <= $study->getStudy()->getDuration() ){
                        $study->setDurationStatus($study->getDurationStatus() + 1);
                    }

                    $study->setYearStatus(0);
                }
            }


            
            //Global salary
            if($character->getJob() != null){
                $character->setMoney($character->getMoney() + $character->getJob()->getSalary());
            }
            // Specific salary

                // Pharmacien
                if($character->getJob() != null){
                    if($character->getJob()->getSlug() == "pharmacien"){

                        $pharmacy = $character->getPharmacy();
    
                        if(($pharmacy->getMoney() - $pharmacy->getOwnerSalary()) > 0){
                            $pharmacy->setMoney($pharmacy->getMoney() - $pharmacy->getOwnerSalary());
                            $character->setMoney($character->getMoney() + $pharmacy->getOwnerSalary());
                            $this->em->persist($pharmacy);
                        }
    
                    }
                }
                

            $this->em->persist($character);
        }



        // update patient list for recall treatment status
        $patientList = $this->em->getRepository(Patient::class)->findAll();

        foreach($patientList as $patient){
            $patient->setRecallTreatmentStatus(0);
            $this->em->persist($patient);
        }

        // handle medic subcription price

            $medicList = $this->em->getRepository(Characters::class)->findBy(['job' => 7]);

            foreach($medicList as $medic){

                $subscriptionPrice = $medic->getMedicPriceSubscription()->getPrice();

                $medicPatientSuscribedList = $this->em->getRepository(Patient::class)->findBySubscriptionAndMedic($medic);

                $medic->setMoney($medic->getMoney() + ($subscriptionPrice * count($medicPatientSuscribedList)));

                $this->em->persist($medic);

                foreach($medicPatientSuscribedList as $patient){
                    $characterPatient = $patient->getPatient();

                    $characterPatient->setMoney($characterPatient->getMoney($subscriptionPrice));

                    $this->em->persist($characterPatient);
                }
            }

                


        // execute
        $this->em->flush();

        $io->success('Mise à jour journalière effectuée');

        $a = 'Daily Update';

        return print_r($a);

        /*$updateMoney = $this->em->getRepository(Characters::class)->find(1);
        $updateMoney->setMoney($updateMoney->getMoney() + 500);
        
        $this->em->persist($updateMoney);
        $this->em->flush();*/
    }
}
