<?php

namespace App\DataFixtures;

use App\Entity\ListeOptionsVehicule;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ListeOptionsVehicules extends Fixture
{

    public function load(ObjectManager $em)
    {

        $tblOptions = ['Lève-glaces électrique AV', 'Lève-glaces électrique AR', 'Direction assistée', 'GPS', 'Caméra de recul', 'Aide au parking', 'Sièges cuir', 'Régulateur de vitesse', 'Boîte automatique', 'Attache remorque', 'Stop & Go', 'Park assist', 'Toit ouvrant électrique'];

        //Création de la liste d'options d'un véhicule        

        for ($i = 0; $i < 10; $i++) {

            $listeOptions = new ListeOptionsVehicule();
            $listeOptions->setVehicule($this->getReference('vehicule_' . $i));
            
            for ($j = 0; $j < count($tblOptions); $j++) {
                $listeOptions->setOptionVehicule($this->getReference('OptionVehicule_' . $i));

                $em->persist($listeOptions);
                $em->flush();
            }
        }
    }
}
