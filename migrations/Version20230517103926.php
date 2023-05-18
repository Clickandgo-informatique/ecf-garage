<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230517103926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicules ADD liste_options_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicules ADD CONSTRAINT FK_78218C2D28319867 FOREIGN KEY (liste_options_id) REFERENCES liste_options_vehicule (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_78218C2D28319867 ON vehicules (liste_options_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicules DROP FOREIGN KEY FK_78218C2D28319867');
        $this->addSql('DROP INDEX UNIQ_78218C2D28319867 ON vehicules');
        $this->addSql('ALTER TABLE vehicules DROP liste_options_id');
    }
}
