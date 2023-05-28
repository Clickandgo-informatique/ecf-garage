<?php
namespace App\DataFixtures;

use App\Entity\TypesVehicules;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypesVehiculesFixtures extends Fixture{

    public function load(ObjectManager $manager):void{

        $types=['citadine','véhicule industriel','familial','berline','limousine','motocyclette','3 roues','quad'];
        
        for($i=0;$i<count($types);$i++){
            
            $type=new TypesVehicules();
            $type->setNomtype($types[$i]);

            $manager->persist($type);
            $this->addReference('type_vehicule_'.$i,$type);
        }
        $manager->flush();
    }
}