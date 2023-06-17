<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230617123821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mails (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, service_id INT DEFAULT NULL, mail VARCHAR(255) NOT NULL, INDEX IDX_63582005FB88E14F (utilisateur_id), INDEX IDX_63582005ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mails ADD CONSTRAINT FK_63582005FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE mails ADD CONSTRAINT FK_63582005ED5CA9E6 FOREIGN KEY (service_id) REFERENCES services (id)');
        $this->addSql('ALTER TABLE vehicules CHANGE publication_annonce publication_annonce TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mails DROP FOREIGN KEY FK_63582005FB88E14F');
        $this->addSql('ALTER TABLE mails DROP FOREIGN KEY FK_63582005ED5CA9E6');
        $this->addSql('DROP TABLE mails');
        $this->addSql('ALTER TABLE vehicules CHANGE publication_annonce publication_annonce TINYINT(1) DEFAULT NULL');
    }
}
