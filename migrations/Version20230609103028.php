<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230609103028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clients (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, nom_marital VARCHAR(100) DEFAULT NULL, prenom VARCHAR(100) NOT NULL, date_naissance DATE DEFAULT NULL, email VARCHAR(100) DEFAULT NULL, telephone_fixe VARCHAR(15) DEFAULT NULL, telephone_mobile VARCHAR(15) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, code_postal VARCHAR(6) DEFAULT NULL, ville VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaires (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, contenu LONGTEXT NOT NULL, actif TINYINT(1) NOT NULL, email VARCHAR(255) NOT NULL, pseudo VARCHAR(255) NOT NULL, rgpd TINYINT(1) NOT NULL, note INT DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_D9BEC0C4727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE couleurs (id INT AUTO_INCREMENT NOT NULL, couleur VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liste_options_vehicule (id INT AUTO_INCREMENT NOT NULL, vehicule_id INT NOT NULL, option_vehicule_id INT NOT NULL, INDEX IDX_C7DC891E4A4A3511 (vehicule_id), INDEX IDX_C7DC891E6C7E6CA5 (option_vehicule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marques (id INT AUTO_INCREMENT NOT NULL, marque VARCHAR(100) NOT NULL, path_icon VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE options_vehicules (id INT AUTO_INCREMENT NOT NULL, nom_option VARCHAR(255) NOT NULL, description_option LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photos (id INT AUTO_INCREMENT NOT NULL, id_vehicule_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_876E0D95258F8E6 (id_vehicule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE types_vehicules (id INT AUTO_INCREMENT NOT NULL, nom_type VARCHAR(100) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, adresse VARCHAR(255) NOT NULL, code_postal VARCHAR(5) NOT NULL, ville VARCHAR(150) NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', tel_fixe VARCHAR(15) DEFAULT NULL, tel_mobile VARCHAR(15) DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateurs (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicules (id INT AUTO_INCREMENT NOT NULL, marque_id INT NOT NULL, proprietaire_id INT DEFAULT NULL, couleur_id INT NOT NULL, type_vehicule_id INT NOT NULL, modele VARCHAR(100) NOT NULL, motorisation VARCHAR(100) NOT NULL, cylindree INT DEFAULT NULL, nb_portes INT DEFAULT NULL, prix_vente INT NOT NULL, date_mise_en_circulation DATE DEFAULT NULL, nb_places INT DEFAULT NULL, date_mise_en_vente DATE DEFAULT NULL, boite VARCHAR(100) DEFAULT NULL, num_chassis VARCHAR(255) DEFAULT NULL, localisation VARCHAR(100) DEFAULT NULL, date_vente DATE DEFAULT NULL, critere_pollution VARCHAR(100) DEFAULT NULL, date_controle_technique DATE DEFAULT NULL, remarques LONGTEXT DEFAULT NULL, kilometrage INT DEFAULT NULL, nb_proprietaires INT DEFAULT NULL, chevaux_fiscaux DOUBLE PRECISION DEFAULT NULL, chevaux_din DOUBLE PRECISION DEFAULT NULL, reference_interne VARCHAR(100) DEFAULT NULL, plaque_immatriculation VARCHAR(15) DEFAULT NULL, publication_annonce TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', slug VARCHAR(255) NOT NULL, INDEX IDX_78218C2D4827B9B2 (marque_id), INDEX IDX_78218C2D76C50E4A (proprietaire_id), INDEX IDX_78218C2DC31BA576 (couleur_id), INDEX IDX_78218C2D153E280 (type_vehicule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicules_users (vehicules_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_13F3F3BD8D8BD7E2 (vehicules_id), INDEX IDX_13F3F3BD67B3B43D (users_id), PRIMARY KEY(vehicules_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C4727ACA70 FOREIGN KEY (parent_id) REFERENCES commentaires (id)');
        $this->addSql('ALTER TABLE liste_options_vehicule ADD CONSTRAINT FK_C7DC891E4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicules (id)');
        $this->addSql('ALTER TABLE liste_options_vehicule ADD CONSTRAINT FK_C7DC891E6C7E6CA5 FOREIGN KEY (option_vehicule_id) REFERENCES options_vehicules (id)');
        $this->addSql('ALTER TABLE photos ADD CONSTRAINT FK_876E0D95258F8E6 FOREIGN KEY (id_vehicule_id) REFERENCES vehicules (id)');
        $this->addSql('ALTER TABLE vehicules ADD CONSTRAINT FK_78218C2D4827B9B2 FOREIGN KEY (marque_id) REFERENCES marques (id)');
        $this->addSql('ALTER TABLE vehicules ADD CONSTRAINT FK_78218C2D76C50E4A FOREIGN KEY (proprietaire_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE vehicules ADD CONSTRAINT FK_78218C2DC31BA576 FOREIGN KEY (couleur_id) REFERENCES couleurs (id)');
        $this->addSql('ALTER TABLE vehicules ADD CONSTRAINT FK_78218C2D153E280 FOREIGN KEY (type_vehicule_id) REFERENCES types_vehicules (id)');
        $this->addSql('ALTER TABLE vehicules_users ADD CONSTRAINT FK_13F3F3BD8D8BD7E2 FOREIGN KEY (vehicules_id) REFERENCES vehicules (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vehicules_users ADD CONSTRAINT FK_13F3F3BD67B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C4727ACA70');
        $this->addSql('ALTER TABLE liste_options_vehicule DROP FOREIGN KEY FK_C7DC891E4A4A3511');
        $this->addSql('ALTER TABLE liste_options_vehicule DROP FOREIGN KEY FK_C7DC891E6C7E6CA5');
        $this->addSql('ALTER TABLE photos DROP FOREIGN KEY FK_876E0D95258F8E6');
        $this->addSql('ALTER TABLE vehicules DROP FOREIGN KEY FK_78218C2D4827B9B2');
        $this->addSql('ALTER TABLE vehicules DROP FOREIGN KEY FK_78218C2D76C50E4A');
        $this->addSql('ALTER TABLE vehicules DROP FOREIGN KEY FK_78218C2DC31BA576');
        $this->addSql('ALTER TABLE vehicules DROP FOREIGN KEY FK_78218C2D153E280');
        $this->addSql('ALTER TABLE vehicules_users DROP FOREIGN KEY FK_13F3F3BD8D8BD7E2');
        $this->addSql('ALTER TABLE vehicules_users DROP FOREIGN KEY FK_13F3F3BD67B3B43D');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE commentaires');
        $this->addSql('DROP TABLE couleurs');
        $this->addSql('DROP TABLE liste_options_vehicule');
        $this->addSql('DROP TABLE marques');
        $this->addSql('DROP TABLE options_vehicules');
        $this->addSql('DROP TABLE photos');
        $this->addSql('DROP TABLE types_vehicules');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE utilisateurs');
        $this->addSql('DROP TABLE vehicules');
        $this->addSql('DROP TABLE vehicules_users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
