<?php

namespace App\DataFixtures;

use App\Entity\Homepage;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HomepageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $homepage = new Homepage();
        $homepage->setTitrePrincipal("Garage Parrot")
            ->setSousTitre("Un gage de sérieux pour votre véhicule")
            ->setDescription("<p>Bienvenue sur le site web du garage Parrot situé à Toulouse, dans la ville rose !.</p><p>Nous vous offrons tous les services indispensables à l'entretien de votre véhicule ainsi qu'une liste interminable de véhicules 0km ou d'occasion...</p>
        <p>N'hésitez pas à nous contacter (soit par mail soit par télephone) et laisser appréciations et commentaires.</p> 
        <p>Vincent Parrot et toute son équipe vous souhaitent bonne navigation sur ce site, restant à votre disposition pour toute demande.</p>");

        $manager->persist($homepage);
        $manager->flush();
    }
}
