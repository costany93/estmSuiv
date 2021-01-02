<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201223222529 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE information ADD club_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE information ADD CONSTRAINT FK_2979188361190A32 FOREIGN KEY (club_id) REFERENCES club (id)');
        $this->addSql('CREATE INDEX IDX_2979188361190A32 ON information (club_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE information DROP FOREIGN KEY FK_2979188361190A32');
        $this->addSql('DROP INDEX IDX_2979188361190A32 ON information');
        $this->addSql('ALTER TABLE information DROP club_id');
    }
}
