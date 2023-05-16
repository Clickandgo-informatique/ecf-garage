<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230516103205 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicules ADD proprietaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vehicules ADD CONSTRAINT FK_78218C2D76C50E4A FOREIGN KEY (proprietaire_id) REFERENCES clients (id)');
        $this->addSql('CREATE INDEX IDX_78218C2D76C50E4A ON vehicules (proprietaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicules DROP FOREIGN KEY FK_78218C2D76C50E4A');
        $this->addSql('DROP INDEX IDX_78218C2D76C50E4A ON vehicules');
        $this->addSql('ALTER TABLE vehicules DROP proprietaire_id');
    }
}
