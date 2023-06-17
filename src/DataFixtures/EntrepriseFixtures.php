<?php

namespace App\DataFixtures;

use App\Entity\Entreprise;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EntrepriseFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $entreprise = new Entreprise();

        $entreprise->setNomEntreprise("Garage Parrot Paris")
            ->setAdresse("32 rue du Moulin")
            ->setCodepostal("75001")
            ->setVille("Paris")
            ->setSiren("123456789")
            ->setGerant("Pierre Dupondt");

        $manager->persist($entreprise);
        $manager->flush();
    }
}
