<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260405090155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, start_at DATETIME NOT NULL, end_at DATETIME NOT NULL, created_at DATETIME NOT NULL, status VARCHAR(50) NOT NULL, user_id INT NOT NULL, resource_id INT NOT NULL, INDEX IDX_42C84955A76ED395 (user_id), INDEX IDX_42C8495589329D25 (resource_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE resource (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, description LONGTEXT DEFAULT NULL, capacity INT DEFAULT NULL, is_available TINYINT NOT NULL, created_at DATETIME NOT NULL, resource_type_id INT NOT NULL, INDEX IDX_BC91F41698EC6B7B (resource_type_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE resource_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495589329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE resource ADD CONSTRAINT FK_BC91F41698EC6B7B FOREIGN KEY (resource_type_id) REFERENCES resource_type (id)');
        $this->addSql('ALTER TABLE user ADD firstname VARCHAR(100) NOT NULL, ADD lastname VARCHAR(150) NOT NULL, ADD created_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495589329D25');
        $this->addSql('ALTER TABLE resource DROP FOREIGN KEY FK_BC91F41698EC6B7B');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE resource');
        $this->addSql('DROP TABLE resource_type');
        $this->addSql('ALTER TABLE user DROP firstname, DROP lastname, DROP created_at');
    }
}
