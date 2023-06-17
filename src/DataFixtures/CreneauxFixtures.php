<?php

namespace App\DataFixtures;

use App\Entity\Creneaux;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CreneauxFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

        for ($i = 0; $i < count($jours); $i++) {
            //Premier créneau
            $creneau = new Creneaux();
            $creneau->setJour($jours[$i])
                ->setDebut(new \datetime('09:00'))
                ->setFin(new \datetime('12:30'));
            $manager->persist($creneau);

            //Deuxième créneau
            $creneau = new Creneaux();
            $creneau->setJour($jours[$i])
                ->setDebut(new \datetime('14:00'))
                ->setFin(new \datetime('19:30'));

            $manager->persist($creneau);
        }
        $manager->flush();
    }
}
