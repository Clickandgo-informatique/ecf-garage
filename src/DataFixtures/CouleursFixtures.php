<?php

namespace App\DataFixtures;

use App\Entity\Couleurs;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CouleursFixtures extends Fixture
{

    public function load(ObjectManager $om): void
    {

        $tblCouleurs = ["Blanc", "Blanc nacré", "Gris-Nardo", "Gris-métallisé", "Rouge", "Noir", "Anthracite", "Bleu électrique", "Bleu", "Vert tilleul métallisé", "Vert métallisé", "N.C."];

        for ($i = 0; $i < count($tblCouleurs); $i++) {

            $couleur = new Couleurs();
            $couleur->setCouleur($tblCouleurs[$i]);

            $om->persist($couleur);

            $this->addReference('couleur_' . $i, $couleur);
        }
        $om->flush();
    }
}
