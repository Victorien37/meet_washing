<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240605164603 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicule ADD vehicule_type_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D2D57830F FOREIGN KEY (vehicule_type_id_id) REFERENCES vehicule_type (id)');
        $this->addSql('CREATE INDEX IDX_292FFF1D2D57830F ON vehicule (vehicule_type_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D2D57830F');
        $this->addSql('DROP INDEX IDX_292FFF1D2D57830F ON vehicule');
        $this->addSql('ALTER TABLE vehicule DROP vehicule_type_id_id');
    }
}
