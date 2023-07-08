<?php

namespace App\DataFixtures;

use App\Entity\ListeOptionsVehicule;
use App\Entity\Photos;
use App\Entity\Vehicules;
use App\Service\PicturesService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker\Factory;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class VehiculesFixtures extends Fixture
{


    public function __construct(
        private SluggerInterface $slugger,
        private PicturesService $picturesService
    ) {
    }

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr_FR');

        $tblBadges = ['', 'Peu de km !', 'Occasion récente !', 'Occasion rare', 'Etat exceptionnel'];
        $tblMarques = ['Alfa-Romeo', 'Aston-Martin', 'Bentley', 'BMW', 'Citroen', 'DS automobiles', 'Jaguar', 'Mercedes', 'Peugeot', 'Renault', 'Rolls-Royce', 'Toyota', 'Volkswagen'];


        $couleurs = ["Rouge", "Gris-métallisé", "Gris-Perle métallisé", "Blanc", "Bleu-clair", "Noir", "Anthracite"];
        $tblOptions = ['Lève-glaces électrique AV', 'Lève-glaces électrique AR', 'Direction assistée', 'GPS', 'Caméra de recul', 'Aide au parking', 'Sièges cuir', 'Régulateur de vitesse', 'Boîte automatique', 'Attache remorque', 'Stop & Go', 'Park assist', 'Toit ouvrant électrique'];


        $lengthMarques = count($tblMarques);
        $lengthCouleurs = count($couleurs);

        for ($i = 0; $i <= 20; $i++) {

            //Random sur les valeurs des tableaux fictifs
            $randomMarques = rand(0, $lengthMarques - 1);

            //Création des données du véhicule
            $v = new Vehicules();
            $v->setReferenceInterne(rand(00001, 99999))
                ->setProprietaire($this->getReference('Client_' . rand(0, 9)))
                ->setMarque($this->getReference('Marque_' . rand(1, $randomMarques)))
                ->setModele("modele_" . rand(0001, 1000))
                ->setCouleur($this->getReference('couleur_' . rand(0, 11)))
                ->setMotorisation($this->getReference('motorisation_' . rand(0, 6)))
                ->setTypeVehicule($this->getReference('type_vehicule_' . rand(0, 7)))
                ->setBoite($this->getReference('Boite_' . rand(0, 4)))
                ->setCylindree(rand(1000, 5600))
                ->setNbPlaces(rand(1, 10))
                ->setNbPortes(rand(2, 5))
                ->setPrixVente(rand(3500, 300000))
                ->setKilometrage(rand(1000, 200000))
                ->setChevauxDin(rand(1, 1000))
                ->setChevauxFiscaux(10.00, 400.00)
                ->setRemarques("Aucune remarque")
                ->setPlaqueImmatriculation('AA-' . rand(0001, 9999) . '-ZZ')
                ->setSlug($this->slugger->slug($v->getMarque() . ' ' . $v->getModele())->lower())
                ->setPublicationAnnonce(true)
                ->setdatemiseencirculation($faker->dateTimeThisDecade())
                ->setbadgeannonce($faker->randomElement($tblBadges))
                ->setDateMiseEnVente($faker->dateTimeThisYear())
                ->setnumchassis($faker->randomElement(['a', 'b', 'c', 'd', 'e']) . '-' . rand(1000000, 10000000) . '-' . $faker->randomElement(['aa', 'bb', 'cc', 'dd', 'ee']))
                ->setlocalisation('Toulouse')
                ->setcriterepollution(rand(1, 6))
                ->setdatecontroletechnique($faker->datetimethisyear())
                ->setnbproprietaires(rand(1, 5));

            $manager->persist($v);
            $this->addReference('vehicule_' . $i, $v);
            $manager->flush();

            //Création de la liste d'options du véhicule actuel
            $max = count($tblOptions) - 1;

            for ($j = 0; $j < rand(1, $max); $j++) {
                $listeOptions = new ListeOptionsVehicule();

                $listeOptions->setVehicule($v);
                $listeOptions->setOptionVehicule($this->getReference('OptionVehicule_' . rand(1, $max)));
                $manager->persist($listeOptions);
                $manager->flush();
            }

            //Création de la liste d'images pour le véhicule actuel 
            $sourceDir = 'src/DataFixtures/img/';

            //Dossier de destination
            $folder = 'vehicules';

            //Mise en tableau de toutes les images présentes dans le dossier local (src/Datafixtures/img)
            $files = array_values(array_diff(scandir($sourceDir), array('..', '.')));

            //Extraction du chemin complet et des noms de fichiers
            $filesPath = [];
            $filesNames = [];

            //Remplissage des tableaux pour chaque fichier
            foreach ($files as $file) {
                $filesPath[] = $sourceDir . $file;
                $filesNames[] = $file;
            }
dd($filesNames);
            //Exécution d'un random sur le tableau d'images en local
            $fichiers = $faker->randomElements($filesNames,4);

            // création de chaque fichier image
            for ($k = 0; $k < count($fichiers); $k++) {

                $photo = new UploadedFile($filesPath[$k], $filesNames[$k], null, null, true);

                //Appel au service d'ajout d'images 
                $fichier = $this->picturesService->add($photo, $folder, 300, 300, false);

                $photoUploaded = new Photos();
                $photoUploaded->setNom($fichier);
                $v->addPhoto($photoUploaded);

                $manager->persist($photoUploaded);
                $manager->persist($v);
                $manager->flush();
            }
        }
    }


    public function getDependencies()
    {
        return [
            BoitesFixtures::class,
            ClientsFixtures::class,
            Couleurs::class,
            MarquesFixtures::class,
            Motorisations::class,
            OptionsVehiculesFixtures::class,
            TypesVehicules::class,
        ];
    }
}
