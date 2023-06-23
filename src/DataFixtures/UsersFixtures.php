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
        $admin->setNom('Dupont');
        $admin->setPrenom('Benoit');
        $admin->setAdresse('12 rue du port');
        $admin->setCodePostal('75001');
        $admin->setVille('Paris');
        $admin->setPassword(
            $this->passwordEncoder->hashPassword($admin, 'admin')
        );
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);
        
        //Création fixture employé 1
        $employee = new Users();
        $employee->setEmail('employe1@demo.fr');
        $employee->setNom('De La Fontaine');
        $employee->setPrenom('Jean-Marie');
        $employee->setAdresse('152 rue du Chêne-doré');
        $employee->setCodePostal('01500');
        $employee->setVille('Ambérieu-en-Bugey');
        $employee->setPassword(
            $this->passwordEncoder->hashPassword($employee, 'employee')
        );
        $employee->setRoles(['ROLE_EMPLOYEE']);

        $manager->persist($employee);

        //Création fixture employé 2
        $employee = new Users();
        $employee->setEmail('employe2@demo.fr');
        $employee->setNom('Weil-Sinclair');
        $employee->setPrenom('Simone');
        $employee->setAdresse('15 av Gambetta');
        $employee->setCodePostal('32420');
        $employee->setVille('Simorre');
        $employee->setPassword(
            $this->passwordEncoder->hashPassword($employee, 'employee')
        );
        $employee->setRoles(['ROLE_EMPLOYEE']);

        $manager->persist($employee);

        for ($i = 0; $i < 10; $i++) {

            $user = new Users();
            $user->setNom($faker->lastName)
                ->setPrenom($faker->firstName)
                ->setTelFixe($faker->phoneNumber)
                ->setTelMobile($faker->phoneNumber)
                ->setAdresse($faker->address)
                ->setCodePostal(str_replace(' ','',$faker->postcode))
                ->setVille($faker->city)
                ->setEmail($faker->email)
                ->setPassword($this->passwordEncoder->hashPassword($user,'azerty'));

            $manager->persist($user);
            $manager->flush();
        }
    }
}
