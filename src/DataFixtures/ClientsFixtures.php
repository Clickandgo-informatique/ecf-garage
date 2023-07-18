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
            $client->setNom($faker->lastName())
                ->setPrenom($faker->firstName())
                ->setTelephoneFixe($faker->phoneNumber())
                ->setTelephoneMobile($faker->phoneNumber())
                ->setAdresse($faker->streetName())
                ->setCodePostal(str_replace(' ', '', $faker->postcode()))
                ->setVille($faker->city())
                ->setEmail($faker->email());

            $manager->persist($client);
            $this->addReference('Client_' . $i, $client);
            $manager->flush();
        }
    }
}
