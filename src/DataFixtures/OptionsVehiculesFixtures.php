<?php

namespace App\DataFixtures;

use App\Entity\OptionsVehicules;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OptionsVehiculesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $tblOptions = ['Lève-glaces électrique AV', 'Lève-glaces électrique AR', 'Direction assistée', 'GPS', 'Caméra de recul', 'Aide au parking', 'Sièges cuir', 'Régulateur de vitesse', 'Boîte automatique', 'Attache remorque', 'Stop & Go', 'Park assist', 'Toit ouvrant électrique'];

        for ($i = 0; $i < count($tblOptions) - 1; $i++) {

            $option = new OptionsVehicules();
            $option->setNomOption($tblOptions[$i]);
            $option->setDescriptionOption('Aucune description');
            $manager->persist($option);
            $this->addReference('OptionVehicule_' . $i, $option);
        }
        $manager->flush();
    }
}
