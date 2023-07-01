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
            ->setCodepostal("31001")
            ->setVille("Toulouse")
            ->setSiren("123456789")
            ->setGerant("Vincent Parrot")
            ->setTel1("01.02.03.04.05")
            ->setTel2("02.03.04.05.06")
            ->setMailprincipal('contact@garage-parrot.fr')
            ->setMailsecondaire('administratif@garage-parrot.fr')
            ->setMailAnnoncesOccasions('annonces-occasions@garage-parrot.fr')      
            
            ;

        $manager->persist($entreprise);
        $manager->flush();
    }
}
