<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordEncoder){
        
    }
    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create('fr_FR');
        //Création fixture administrateur
        $admin = new Users();
        $admin->setEmail('admin@demo.fr');
        $admin->setNom('Gambier');
        $admin->setPrenom('Benoit');
        $admin->setAdresse('12 rue du port');
        $admin->setCodePostal('75001');
        $admin->setVille('Paris');
        $admin->setPassword(
            $this->passwordEncoder->hashPassword($admin, 'admin')
        );
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        for ($i = 0; $i < 100; $i++) {

            $user = new Users();
            $user->setNom($faker->lastName)
                ->setPrenom($faker->firstName)
                ->setTelFixe($faker->phoneNumber)
                ->setTelMobile($faker->phoneNumber)
                ->setAdresse($faker->address)
                ->setCodePostal($faker->postcode)
                ->setVille($faker->city)
                ->setEmail($faker->email)
                ->setPassword($this->passwordEncoder->hashPassword($user,'azerty'));

            $manager->persist($user);
            $manager->flush();
        }
    }
}
