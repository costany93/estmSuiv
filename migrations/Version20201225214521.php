<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201225214521 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE adhesion (id INT AUTO_INCREMENT NOT NULL, etudiant_id INT NOT NULL, club_id INT NOT NULL, type TINYINT(1) DEFAULT NULL, motif LONGTEXT NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_C50CA65ADDEAB1A3 (etudiant_id), INDEX IDX_C50CA65A61190A32 (club_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adhesion ADD CONSTRAINT FK_C50CA65ADDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE adhesion ADD CONSTRAINT FK_C50CA65A61190A32 FOREIGN KEY (club_id) REFERENCES club (id)');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A25DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('CREATE INDEX IDX_DADD4A25DDEAB1A3 ON answer (etudiant_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE adhesion');
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A25DDEAB1A3');
        $this->addSql('DROP INDEX IDX_DADD4A25DDEAB1A3 ON answer');
    }
}
