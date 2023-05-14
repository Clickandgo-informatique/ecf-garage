<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230513164556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicules ADD num_chassis VARCHAR(255) DEFAULT NULL, ADD localisation VARCHAR(100) DEFAULT NULL, ADD date_vente DATE DEFAULT NULL, ADD critere_pollution VARCHAR(100) DEFAULT NULL, ADD date_controle_technique DATE DEFAULT NULL, ADD remarques LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicules DROP num_chassis, DROP localisation, DROP date_vente, DROP critere_pollution, DROP date_controle_technique, DROP remarques');
    }
}
