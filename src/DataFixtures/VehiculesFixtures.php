<?php

namespace App\DataFixtures;

use App\Entity\Vehicules;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Length;

class VehiculesFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {

        $marques = ["Renault", "Peugeot", "Citroen", "Toyota", "Mercedes-Benz"];
        $motorisations = ["Diesel", "Essence", "GPL", "Hybride", "Electrique"];
        $types = ["Fourgonnette", "Familiale", "Citadine", "Véhicule entreprise", "Véhicule industriel", "Camionnette"];
        $boites = ["Manuelle", "Auto"];

        $lengthMarques = count($marques);
        $lengthMotorisations = count($motorisations);
        $lengthTypes = count($types);
        $lengthBoites = count($boites);

        for ($i = 0; $i <= 10; $i++) {

            //Random sur les valeurs des tableaux fictifs
            $randomMarques = rand(0, $lengthMarques - 1);
            $randomMotorisations = rand(0, $lengthMotorisations - 1);
            $randomTypes = rand(0, $lengthTypes - 1);
            $randomBoites = rand(0, $lengthBoites - 1);

            //Random sur les dates
            // $timestamp = rand(strtotime("Jan 01 2015"), strtotime("Nov 01 2023"));
            // $random_Date = new \DateTime("d-m-Y",);

            $v = new Vehicules();
            $v->setMarque($marques[$randomMarques])
            ->setModele("nc")
            ->setCouleur('blanche')            
            ->setMotorisation($motorisations[$randomMotorisations])
            ->setTypeVehicule($types[$randomTypes])
            ->setBoite($boites[$randomBoites])
            ->setCylindree(rand(1000, 5600))
            ->setNbPlaces(rand(1, 10))
            ->setNbPortes(rand(2, 5))
            ->setPrixVente(rand(3500, 300000))
            ->setKilometrage(rand(1000,200000))
            ->setChevauxDin(rand(1,1000))
            ->setChevauxFiscaux(10.00,400.00)
            ;
            // $v->setDateMiseEnCirculation($random_Date);
            // $v->setDateMiseEnVente($random_Date);

            $manager->persist($v);
        }

        $manager->flush();
    }
}
