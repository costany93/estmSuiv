<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201221211313 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE classe (id INT AUTO_INCREMENT NOT NULL, filiere_id INT NOT NULL, numero INT NOT NULL, niveau VARCHAR(255) NOT NULL, annee VARCHAR(255) NOT NULL, INDEX IDX_8F87BF96180AA129 (filiere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE filiere (id INT AUTO_INCREMENT NOT NULL, departement_id INT NOT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_2ED05D9ECCF9E01E (departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, fistname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, sexe VARCHAR(255) NOT NULL, date_naiss DATETIME NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF96180AA129 FOREIGN KEY (filiere_id) REFERENCES filiere (id)');
        $this->addSql('ALTER TABLE filiere ADD CONSTRAINT FK_2ED05D9ECCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE filiere DROP FOREIGN KEY FK_2ED05D9ECCF9E01E');
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF96180AA129');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE filiere');
        $this->addSql('DROP TABLE user');
    }
}
