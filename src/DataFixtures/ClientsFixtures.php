<?php

namespace App\DataFixtures;

use App\Entity\Clients;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ClientsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {

            $client = new Clients();
            $client->setNom($faker->firstName)
                ->setPrenom($faker->lastname)
                ->setTelephoneFixe('01.02.03.04.05')
                ->setTelephoneMobile('01.02.03.04.05')
                ->setAdresse($faker->address)
                ->setCodePostal($faker->postcode)
                ->setVille($faker->city)
                ->setEmail($faker->email);

            $manager->persist($client);
              $this->addReference('Client_' . $i, $client);
            $manager->flush();
        }
    }
}
