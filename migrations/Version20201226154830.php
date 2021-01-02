<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201226154830 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F61190A32');
        $this->addSql('DROP INDEX IDX_AB55E24F61190A32 ON participation');
        $this->addSql('ALTER TABLE participation CHANGE club_id activity_id INT NOT NULL');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F81C06096 FOREIGN KEY (activity_id) REFERENCES activity (id)');
        $this->addSql('CREATE INDEX IDX_AB55E24F81C06096 ON participation (activity_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24F81C06096');
        $this->addSql('DROP INDEX IDX_AB55E24F81C06096 ON participation');
        $this->addSql('ALTER TABLE participation CHANGE activity_id club_id INT NOT NULL');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24F61190A32 FOREIGN KEY (club_id) REFERENCES club (id)');
        $this->addSql('CREATE INDEX IDX_AB55E24F61190A32 ON participation (club_id)');
    }
}
