<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260418155353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE equipment (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(200) NOT NULL, quantity INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE room_equipment (id INT AUTO_INCREMENT NOT NULL, quantity INT NOT NULL, resource_id INT NOT NULL, equipment_id INT DEFAULT NULL, INDEX IDX_4F9135EA89329D25 (resource_id), INDEX IDX_4F9135EA517FE9FE (equipment_id), UNIQUE INDEX unique_room_equipment (resource_id, equipment_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE room_equipment ADD CONSTRAINT FK_4F9135EA89329D25 FOREIGN KEY (resource_id) REFERENCES resource (id)');
        $this->addSql('ALTER TABLE room_equipment ADD CONSTRAINT FK_4F9135EA517FE9FE FOREIGN KEY (equipment_id) REFERENCES equipment (id)');
        $this->addSql('ALTER TABLE resource DROP equipment');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE room_equipment DROP FOREIGN KEY FK_4F9135EA89329D25');
        $this->addSql('ALTER TABLE room_equipment DROP FOREIGN KEY FK_4F9135EA517FE9FE');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('DROP TABLE room_equipment');
        $this->addSql('ALTER TABLE resource ADD equipment JSON NOT NULL');
    }
}
