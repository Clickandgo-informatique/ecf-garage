<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230627115713 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boites ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE vehicules ADD boite_id INT NOT NULL, DROP boite');
        $this->addSql('ALTER TABLE vehicules ADD CONSTRAINT FK_78218C2D3C43472D FOREIGN KEY (boite_id) REFERENCES boites (id)');
        $this->addSql('CREATE INDEX IDX_78218C2D3C43472D ON vehicules (boite_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE boites DROP slug');
        $this->addSql('ALTER TABLE vehicules DROP FOREIGN KEY FK_78218C2D3C43472D');
        $this->addSql('DROP INDEX IDX_78218C2D3C43472D ON vehicules');
        $this->addSql('ALTER TABLE vehicules ADD boite VARCHAR(100) DEFAULT NULL, DROP boite_id');
    }
}
