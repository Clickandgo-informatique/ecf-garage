<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230710115343 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE liste_options_vehicule (id INT AUTO_INCREMENT NOT NULL, vehicule_id INT NOT NULL, INDEX IDX_C7DC891E4A4A3511 (vehicule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE liste_options_vehicule ADD CONSTRAINT FK_C7DC891E4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicules (id)');
        $this->addSql('ALTER TABLE options_vehicules ADD liste_options_vehicule_id INT NOT NULL');
        $this->addSql('ALTER TABLE options_vehicules ADD CONSTRAINT FK_5452281015DDF670 FOREIGN KEY (liste_options_vehicule_id) REFERENCES liste_options_vehicule (id)');
        $this->addSql('CREATE INDEX IDX_5452281015DDF670 ON options_vehicules (liste_options_vehicule_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE options_vehicules DROP FOREIGN KEY FK_5452281015DDF670');
        $this->addSql('ALTER TABLE liste_options_vehicule DROP FOREIGN KEY FK_C7DC891E4A4A3511');
        $this->addSql('DROP TABLE liste_options_vehicule');
        $this->addSql('DROP INDEX IDX_5452281015DDF670 ON options_vehicules');
        $this->addSql('ALTER TABLE options_vehicules DROP liste_options_vehicule_id');
    }
}
