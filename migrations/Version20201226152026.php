<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201226152026 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE activity_etudiant');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE activity_etudiant (activity_id INT NOT NULL, etudiant_id INT NOT NULL, INDEX IDX_D17492ED81C06096 (activity_id), INDEX IDX_D17492EDDDEAB1A3 (etudiant_id), PRIMARY KEY(activity_id, etudiant_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE activity_etudiant ADD CONSTRAINT FK_D17492ED81C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE activity_etudiant ADD CONSTRAINT FK_D17492EDDDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON DELETE CASCADE');
    }
}
