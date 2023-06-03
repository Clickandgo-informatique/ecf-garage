<?php

namespace App\DataFixtures;

use App\Entity\TypesVehicules;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class TypesVehiculesFixtures extends Fixture
{    
    public function __construct(private SluggerInterface $slugger){      
        
    }        
    
    public function load(ObjectManager $manager): void
    {
        
        $types = ['citadine', 'véhicule industriel', 'familial', 'berline', 'limousine', 'motocyclette', '3 roues', 'quad'];
        
        for ($i = 0; $i < count($types); $i++) {
            
            $type = new TypesVehicules();
            $type->setNomtype($types[$i]);
            $type->setSlug($this->slugger->slug($types[$i]));
            
            $manager->persist($type);
            $this->addReference('type_vehicule_' . $i, $type);
        }
        $manager->flush();
    }
}
