<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220530072144 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE deco_murale_photo (id INT AUTO_INCREMENT NOT NULL, deco_murale_id INT NOT NULL, quantite_deco INT NOT NULL, date_creation DATETIME NOT NULL, INDEX IDX_DC416B68BB1074DE (deco_murale_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, tirage_photo_id INT NOT NULL, deco_murale_photo_id INT DEFAULT NULL, photo VARCHAR(40) NOT NULL, INDEX IDX_14B78418A76ED395 (user_id), INDEX IDX_14B78418E8517424 (tirage_photo_id), INDEX IDX_14B78418A7579C1E (deco_murale_photo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE deco_murale_photo ADD CONSTRAINT FK_DC416B68BB1074DE FOREIGN KEY (deco_murale_id) REFERENCES deco_murale (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418E8517424 FOREIGN KEY (tirage_photo_id) REFERENCES tirage_photo (id)');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418A7579C1E FOREIGN KEY (deco_murale_photo_id) REFERENCES deco_murale_photo (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418A7579C1E');
        $this->addSql('DROP TABLE deco_murale_photo');
        $this->addSql('DROP TABLE photo');
    }
}
