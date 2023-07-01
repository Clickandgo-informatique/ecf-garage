<?php

namespace App\DataFixtures;

use App\Entity\Boites;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BoitesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $tblBoites = ['Manuelle', 'CVT', 'Séquentielle', 'Automatique', 'DCT'];

        for ($i = 0; $i < count($tblBoites); $i++) {
            $boite = new Boites();
            $boite->setDescriptionBoite($tblBoites[$i]);
            $boite->setSlug($boite->getDescriptionBoite());

            $manager->persist($boite);
            $this->addReference('Boite_' . $i, $boite);
        }
        $manager->flush();
    }
}
