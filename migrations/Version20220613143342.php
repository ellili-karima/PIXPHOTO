<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220613143342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE deco_murale_photo DROP INDEX couleur_id, ADD INDEX IDX_DC416B68C31BA576 (couleur_id)');
        $this->addSql('ALTER TABLE deco_murale_photo CHANGE couleur_id couleur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE deco_murale_photo ADD CONSTRAINT FK_DC416B68C31BA576 FOREIGN KEY (couleur_id) REFERENCES couleur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE deco_murale_photo DROP INDEX IDX_DC416B68C31BA576, ADD UNIQUE INDEX couleur_id (couleur_id)');
        $this->addSql('ALTER TABLE deco_murale_photo DROP FOREIGN KEY FK_DC416B68C31BA576');
        $this->addSql('ALTER TABLE deco_murale_photo CHANGE couleur_id couleur_id INT NOT NULL');
    }
}
