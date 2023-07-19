<?php

namespace App\DataFixtures;

use App\Entity\Services;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class ServicesFixtures extends Fixture
{

    public function __construct(private SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");

        $civilites = ['Madame', 'Monsieur'];

        $tblNomServices = ['Dépannage rapide', 'Carrosserie', 'Peinture', 'Contrôle technique', 'Location de véhicules', 'Nettoyage intégral', 'Adaptation GPL', 'Pneumatiques'];
        $tblIconesServices=['fa-solid fa-screwdriver-wrench','fa-solid fa-car-burst','fa-solid fa-spray-can','fa-solid fa-stethoscope','fa-solid fa-truck-ramp-box','fa-solid fa-spray-can-sparkles','fa-solid fa-toolbox','fa-solid fa-truck-monster'];

        for ($i = 0; $i < count($tblNomServices); $i++) {

            $service = new Services;
            $service->setNom($tblNomServices[$i])
            ->setIcone($tblIconesServices[$i])
                ->setResume($faker->realText(60))
                ->setDescription($faker->realText(350))
                ->setSlug($this->slugger->slug($service->getNom())->lower())
                ->setPrixAPartirDe(rand(10, 100))
                ->setTelephone1($faker->phoneNumber())
                ->setTelephone2($faker->phoneNumber())
                ->setResponsable($faker->lastName().' '.$faker->firstName)
                ->setMailService1($service->getSlug() . '@garage.com')
                ->setMailService1($service->getSlug() . '@concession-paris.com')
                ->setAfficher(true)
                ->setCiviliteResponsable($civilites[rand(0, 1)]);


            $manager->persist($service);
            $manager->flush();
        }
    }
}
