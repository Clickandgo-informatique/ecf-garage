<?php

namespace   App\DataFixtures;

use App\Entity\Commentaires;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CommentsFixtures extends Fixture
{
    public function load(ObjectManager $om): void
    {

        for ($i = 0; $i < 25; $i++) {

            $comment = new Commentaires();
            $comment->setContenu("Commentaire " . $i);
            $comment->setEmail("email".$i."@demo.fr");
            $comment->setPseudo("Pseudo ".$i);
            $comment->setRgpd(true);
            
            $om->persist($comment);
            $om->flush();
        }
    }
}
