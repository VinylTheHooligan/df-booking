<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260416134408 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE resource ADD location VARCHAR(100) NOT NULL, ADD equipment JSON NOT NULL, CHANGE capacity capacity INT NOT NULL, CHANGE is_available is_enabled TINYINT NOT NULL');
        $this->addSql('ALTER TABLE resource_type ADD description LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE resource DROP location, DROP equipment, CHANGE capacity capacity INT DEFAULT NULL, CHANGE is_enabled is_available TINYINT NOT NULL');
        $this->addSql('ALTER TABLE resource_type DROP description');
    }
}
