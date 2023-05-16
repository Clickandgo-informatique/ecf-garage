<?php

namespace App\DataFixtures;

use App\Entity\Vehicules;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VehiculesFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $tblMarques = ['Alfa-Romeo', 'Aston-Martin', 'Bentley', 'BMW', 'Citroen', 'DS automobiles', 'Jaguar', 'Mercedes', 'Peugeot', 'Renault', 'Rolls-Royce', 'Toyota', 'Volkswagen'];

        $motorisations = ["Diesel", "Essence", "GPL", "Hybride", "Electrique"];
        $types = ["Fourgonnette", "Familiale", "Citadine", "Véhicule entreprise", "Véhicule industriel", "Camionnette"];
        $boites = ["Manuelle", "Auto", "Séquentielle"];
        $couleurs = ["Rouge", "Gris-métallisé", "Gris-Perle métallisé", "Blanc", "Bleu-clair", "Noir", "Anthracite"];

        $lengthMarques = count($tblMarques);
        $lengthMotorisations = count($motorisations);
        $lengthTypes = count($types);
        $lengthBoites = count($boites);
        $lengthCouleurs = count($couleurs);

        for ($i = 0; $i <=20; $i++) {

            //Random sur les valeurs des tableaux fictifs
            $randomMarques = rand(0, $lengthMarques - 1);
            $randomMotorisations = rand(0, $lengthMotorisations - 1);
            $randomTypes = rand(0, $lengthTypes - 1);
            $randomBoites = rand(0, $lengthBoites - 1);
            $randomCouleurs = rand(0, $lengthCouleurs - 1);

            //Random sur les dates
            // $timestamp = rand(strtotime("Jan 01 2015"), strtotime("Nov 01 2023"));
            // $random_Date = new \DateTime("d-m-Y",);

            $v = new Vehicules();
            $v->setReferenceInterne(rand(00001, 99999))
             ->setProprietaire($this->getReference('Client_'.rand(1,3)))
                ->setMarque($this->getReference('Marque_' . rand(1,$randomMarques)))
                ->setModele("nc")
                ->setCouleur($couleurs[$randomCouleurs])
                ->setMotorisation($motorisations[$randomMotorisations])
                ->setTypeVehicule($types[$randomTypes])
                ->setBoite($boites[$randomBoites])
                ->setCylindree(rand(1000, 5600))
                ->setNbPlaces(rand(1, 10))
                ->setNbPortes(rand(2, 5))
                ->setPrixVente(rand(3500, 300000))
                ->setKilometrage(rand(1000, 200000))
                ->setChevauxDin(rand(1, 1000))
                ->setChevauxFiscaux(10.00, 400.00)
                ->setRemarques('Aucune remarque')
                ->setPlaqueImmatriculation('AA-' . rand(0001, 9999) . '-ZZ');
                
            // $v->setDateMiseEnCirculation($random_Date);
            // $v->setDateMiseEnVente($random_Date);

            $manager->persist($v);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [MarquesFixtures::class,ClientsFixtures::class];
    }
}
