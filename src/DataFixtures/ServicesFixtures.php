<?php

namespace App\DataFixtures;

use App\Entity\Services;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class ServicesFixtures extends Fixture
{
    
    public function __construct(private SluggerInterface $slugger) {
        
    }
    
    public function load(ObjectManager $manager): void
    {
        $civilites=['Madame','Monsieur'];

        $tblNomServices = ['Dépannage rapide', 'Carrosserie', 'Peinture', 'Contrôle technique', 'Location de véhicules', 'Nettoyage intégral', 'Adaptation GPL', 'Pneumatiques'];

        for ($i = 0; $i < count($tblNomServices); $i++) {

            $service = new Services;
            $service->setNom($tblNomServices[$i])
                ->setResume("Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit nihil ipsa placeat delectus, sint natus.")
                ->setDescription("Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic fugiat soluta eius, optio odio, labore deleniti repellat architecto neque quod sunt corporis! Reiciendis sit pariatur asperiores, ullam ratione vitae provident?
           Aliquam, porro. Nemo, explicabo autem beatae praesentium dolorem alias. Praesentium consectetur ut enim reprehenderit harum quasi cupiditate provident maxime placeat exercitationem autem iure esse nihil, ipsum tenetur, voluptatem delectus eveniet?
           Eum tempore voluptate, sit sapiente hic beatae voluptas praesentium maxime odit ea aspernatur consequatur omnis atque error fugit ipsam maiores, eligendi accusamus. Necessitatibus saepe laboriosam esse debitis omnis recusandae possimus.
           Ipsa cumque exercitationem rerum molestias nemo sed autem quod, optio ad modi facere odio enim soluta, provident porro consequuntur mollitia sint perferendis culpa asperiores? Harum odit amet sequi perferendis veniam.
           Aperiam perferendis, itaque necessitatibus in cum modi beatae ad quis quidem provident temporibus facere neque. Voluptates, adipisci? Earum molestias beatae nesciunt rem in blanditiis impedit odio! Voluptatibus veritatis vero architecto!
           Cum laborum animi, natus tempora iusto et tenetur molestias id, sit nulla porro corrupti mollitia reiciendis rerum consequuntur? Tenetur corporis ut tempore quibusdam illum aut possimus omnis porro asperiores voluptatibus!
           Corrupti debitis quibusdam doloribus sit cumque modi deleniti placeat laborum fugit, vel iusto animi accusantium consequatur soluta libero officia deserunt at fuga nam aperiam reiciendis asperiores molestiae ad inventore. Incidunt?
           Magni reiciendis adipisci ut ipsum, et, eveniet sint eum facilis officiis minima porro debitis ex eaque nobis voluptatum? Ut hic maiores illum repellat adipisci voluptatum corporis ratione repellendus maxime beatae.
           Natus autem ex quo asperiores tempora! Suscipit, iste iusto nobis animi eligendi expedita libero assumenda modi excepturi aspernatur sequi dicta mollitia itaque porro quia odit, illo ea magni nulla! Beatae.
           Explicabo, deserunt debitis mollitia similique, provident dignissimos illo minima, facere est adipisci officiis libero blanditiis nihil aliquid. Facere accusamus consequatur aliquam nam maiores sint voluptatum placeat unde, illum deleniti aut.")
                ->setSlug($this->slugger->slug($service->getNom())->lower())

                ->setPrixAPartirDe(rand(10, 100))
                ->setTelephone1('01.02.03.04.05')
                ->setTelephone2('09.08.07.06.05')
                ->setResponsable("Responsable_".$i)
                ->setMailService1($service->getSlug().'@garage.com')
                ->setMailService1($service->getSlug().'@concession-paris.com') 
                ->setAfficher(true) 
                ->setCiviliteResponsable($civilites[rand(0,1)])              
                
                ;
                

            $manager->persist($service);
            $manager->flush();
        }
    }
}
