<?php

namespace App\DataFixtures;

use App\Entity\Marques;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MarquesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $tblMarques = ['Alfa-Romeo', 'Aston-Martin', 'Bentley', 'BMW', 'Citroen', 'DS automobiles', 'Jaguar', 'Mercedes', 'Peugeot', 'Renault', 'Rolls-Royce', 'Toyota', 'Volkswagen'];

        for ($i = 0; $i < count($tblMarques) - 1; $i++) {

            $marque = new Marques();
            $marque->setMarque($tblMarques[$i]);
            $manager->persist($marque);
            $this->addReference('Marque_' . $i, $marque);
        }
        $manager->flush();
    }
}
