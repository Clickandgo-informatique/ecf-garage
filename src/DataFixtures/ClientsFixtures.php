<?php

namespace App\DataFixtures;

use App\Entity\Clients;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClientsFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

            $client = new Clients(); 
            $client->setNom('Dupont')
            ->setPrenom('Etienne')
            ->setTelephoneFixe('01.02.03.04.05')
            ->setTelephoneMobile('01.02.03.04.05')
            ->setAdresse('Rue des rosiers')
            ->setCodePostal('75014')
            ->setVille('Paris');                      
           
            $manager->persist($client);

            $this->addReference('Client_' . '1', $client);

            $client = new Clients(); 
            $client->setNom('Durand')
            ->setPrenom('Paule')
            ->setTelephoneFixe('01.02.03.04.05')
            ->setTelephoneMobile('01.02.03.04.05')
            ->setAdresse('Rue des arbustes')
            ->setCodePostal('01500')
            ->setVille('Ambérieu en Bugey');                      
           
            $manager->persist($client);
            $this->addReference('Client_' . '2', $client);
            $client = new Clients(); 
            $client->setNom('De La Marche')
            ->setPrenom('Emilie')
            ->setTelephoneFixe('01.02.03.04.05')
            ->setTelephoneMobile('01.02.03.04.05')
            ->setAdresse('Rue Emile Zola')
            ->setCodePostal('32000')
            ->setVille('Auch');                      
           
            $manager->persist($client);
            $this->addReference('Client_' . '3', $client);            
            
            $manager->flush();
        }
   
}
