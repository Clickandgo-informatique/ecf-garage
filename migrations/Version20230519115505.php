<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230519115505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vehicules_favoris (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicules_favoris_vehicules (vehicules_favoris_id INT NOT NULL, vehicules_id INT NOT NULL, INDEX IDX_9702488B69AD40F9 (vehicules_favoris_id), INDEX IDX_9702488B8D8BD7E2 (vehicules_id), PRIMARY KEY(vehicules_favoris_id, vehicules_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vehicules_favoris_vehicules ADD CONSTRAINT FK_9702488B69AD40F9 FOREIGN KEY (vehicules_favoris_id) REFERENCES vehicules_favoris (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vehicules_favoris_vehicules ADD CONSTRAINT FK_9702488B8D8BD7E2 FOREIGN KEY (vehicules_id) REFERENCES vehicules (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicules_favoris_vehicules DROP FOREIGN KEY FK_9702488B69AD40F9');
        $this->addSql('ALTER TABLE vehicules_favoris_vehicules DROP FOREIGN KEY FK_9702488B8D8BD7E2');
        $this->addSql('DROP TABLE vehicules_favoris');
        $this->addSql('DROP TABLE vehicules_favoris_vehicules');
    }
}
