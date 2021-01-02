<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201225221952 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE membership (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT NOT NULL, club_id INT NOT NULL, content LONGTEXT NOT NULL, state TINYINT(1) DEFAULT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_86FFD285DDEAB1A3 (etudiant_id), INDEX IDX_86FFD28561190A32 (club_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE membership ADD CONSTRAINT FK_86FFD285DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE membership ADD CONSTRAINT FK_86FFD28561190A32 FOREIGN KEY (club_id) REFERENCES club (id)');
        $this->addSql('DROP TABLE adhesion');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE adhesion (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT NOT NULL, club_id INT NOT NULL, type TINYINT(1) DEFAULT NULL, motif LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, created_at DATETIME NOT NULL, INDEX IDX_C50CA65A61190A32 (club_id), UNIQUE INDEX UNIQ_C50CA65ADDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE adhesion ADD CONSTRAINT FK_C50CA65A61190A32 FOREIGN KEY (club_id) REFERENCES club (id)');
        $this->addSql('ALTER TABLE adhesion ADD CONSTRAINT FK_C50CA65ADDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('DROP TABLE membership');
    }
}
