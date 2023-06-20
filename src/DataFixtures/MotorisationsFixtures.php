<?php

namespace App\DataFixtures;

use App\Entity\Motorisations;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class MotorisationsFixtures extends Fixture
{
    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {

        $tblMotorisations = ['Essence', 'Diesel', 'GPL', 'Hybride', 'Hybride rechargeable', 'Electrique', 'Bio-Ethanol-E85'];

        for ($i = 0; $i < count($tblMotorisations); $i++) {

            $motorisation = new Motorisations();
            $motorisation->setNomMotorisation($tblMotorisations[$i]);
            $motorisation->setSlug($this->slugger->slug($motorisation->getNomMotorisation()));

            $manager->persist($motorisation);

            $this->addReference('motorisation_' . $i, $motorisation);
        }
        $manager->flush();
    }
}
