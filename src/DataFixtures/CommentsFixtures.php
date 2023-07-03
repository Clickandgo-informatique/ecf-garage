<?php

namespace   App\DataFixtures;

use App\Entity\Commentaires;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CommentsFixtures extends Fixture
{
    public function load(ObjectManager $om): void
    {
        $faker = Factory::create('fr_FR');
        for ($i = 0; $i < 25; $i++) {

            $comment = new Commentaires();
            $comment->setContenu("Lorem ipsum alea jacta est cave canem in extremis de facto.");
            $comment->setEmail($faker->email());
            $comment->setPseudo("Pseudo " . $i);
            $comment->setRgpd(true);
            $comment->setPublication(true);
            $comment->setNote(rand(0,10));

            $om->persist($comment);
            $om->flush();
        }
    }
}
