<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230710121716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE liste_options_vehicule (id INT AUTO_INCREMENT NOT NULL, vehicule_id INT NOT NULL, option_vehicule_id INT NOT NULL, INDEX IDX_C7DC891E4A4A3511 (vehicule_id), INDEX IDX_C7DC891E6C7E6CA5 (option_vehicule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE liste_options_vehicule ADD CONSTRAINT FK_C7DC891E4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicules (id)');
        $this->addSql('ALTER TABLE liste_options_vehicule ADD CONSTRAINT FK_C7DC891E6C7E6CA5 FOREIGN KEY (option_vehicule_id) REFERENCES options_vehicules (id)');
        $this->addSql('ALTER TABLE options_vehicules CHANGE nom_option nom_option VARCHAR(255) NOT NULL, CHANGE description_option description_option LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liste_options_vehicule DROP FOREIGN KEY FK_C7DC891E4A4A3511');
        $this->addSql('ALTER TABLE liste_options_vehicule DROP FOREIGN KEY FK_C7DC891E6C7E6CA5');
        $this->addSql('DROP TABLE liste_options_vehicule');
        $this->addSql('ALTER TABLE options_vehicules CHANGE nom_option nom_option VARCHAR(100) NOT NULL, CHANGE description_option description_option VARCHAR(255) DEFAULT NULL');
    }
}
