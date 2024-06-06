<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240605164959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1D2D57830F');
        $this->addSql('DROP INDEX IDX_292FFF1D2D57830F ON vehicule');
        $this->addSql('ALTER TABLE vehicule CHANGE vehicule_type_id_id vehicule_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1DFEA7F9B2 FOREIGN KEY (vehicule_type_id) REFERENCES vehicule_type (id)');
        $this->addSql('CREATE INDEX IDX_292FFF1DFEA7F9B2 ON vehicule (vehicule_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1DFEA7F9B2');
        $this->addSql('DROP INDEX IDX_292FFF1DFEA7F9B2 ON vehicule');
        $this->addSql('ALTER TABLE vehicule CHANGE vehicule_type_id vehicule_type_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1D2D57830F FOREIGN KEY (vehicule_type_id_id) REFERENCES vehicule_type (id)');
        $this->addSql('CREATE INDEX IDX_292FFF1D2D57830F ON vehicule (vehicule_type_id_id)');
    }
}
