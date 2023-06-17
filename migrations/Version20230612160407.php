<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230612160407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE creneaux_dimanche (id INT AUTO_INCREMENT NOT NULL, debut TIME NOT NULL, fin TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE creneaux_jeudi (id INT AUTO_INCREMENT NOT NULL, debut TIME NOT NULL, fin TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE creneaux_mardi (id INT AUTO_INCREMENT NOT NULL, debut TIME NOT NULL, fin TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE creneaux_mercredi (id INT AUTO_INCREMENT NOT NULL, debut TIME NOT NULL, fin TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE creneaux_samedi (id INT AUTO_INCREMENT NOT NULL, debut TIME NOT NULL, fin TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE creneaux_vendredi (id INT AUTO_INCREMENT NOT NULL, debut TIME NOT NULL, fin TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE creneaux_dimanche');
        $this->addSql('DROP TABLE creneaux_jeudi');
        $this->addSql('DROP TABLE creneaux_mardi');
        $this->addSql('DROP TABLE creneaux_mercredi');
        $this->addSql('DROP TABLE creneaux_samedi');
        $this->addSql('DROP TABLE creneaux_vendredi');
    }
}
