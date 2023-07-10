<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230710111525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE liste_options_vehicules DROP FOREIGN KEY FK_E1C62EE14A4A3511');
        $this->addSql('ALTER TABLE liste_options_vehicules_options_vehicules DROP FOREIGN KEY FK_C5D2D0F6A25FF866');
        $this->addSql('ALTER TABLE liste_options_vehicules_options_vehicules DROP FOREIGN KEY FK_C5D2D0F6B76111EF');
        $this->addSql('DROP TABLE liste_options_vehicules');
        $this->addSql('DROP TABLE liste_options_vehicules_options_vehicules');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE liste_options_vehicules (id INT AUTO_INCREMENT NOT NULL, vehicule_id INT NOT NULL, INDEX IDX_E1C62EE14A4A3511 (vehicule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE liste_options_vehicules_options_vehicules (liste_options_vehicules_id INT NOT NULL, options_vehicules_id INT NOT NULL, INDEX IDX_C5D2D0F6B76111EF (liste_options_vehicules_id), INDEX IDX_C5D2D0F6A25FF866 (options_vehicules_id), PRIMARY KEY(liste_options_vehicules_id, options_vehicules_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE liste_options_vehicules ADD CONSTRAINT FK_E1C62EE14A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicules (id)');
        $this->addSql('ALTER TABLE liste_options_vehicules_options_vehicules ADD CONSTRAINT FK_C5D2D0F6A25FF866 FOREIGN KEY (options_vehicules_id) REFERENCES options_vehicules (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE liste_options_vehicules_options_vehicules ADD CONSTRAINT FK_C5D2D0F6B76111EF FOREIGN KEY (liste_options_vehicules_id) REFERENCES liste_options_vehicules (id) ON DELETE CASCADE');
    }
}
