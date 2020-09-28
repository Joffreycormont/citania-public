<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200213145630 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE object_effect (id INT AUTO_INCREMENT NOT NULL, object_name VARCHAR(255) NOT NULL, gain INT NOT NULL, lose INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE object_character ADD object_effect_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE object_character ADD CONSTRAINT FK_D0C58FB3B65687BC FOREIGN KEY (object_effect_id) REFERENCES object_effect (id)');
        $this->addSql('CREATE INDEX IDX_D0C58FB3B65687BC ON object_character (object_effect_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE object_character DROP FOREIGN KEY FK_D0C58FB3B65687BC');
        $this->addSql('DROP TABLE object_effect');
        $this->addSql('DROP INDEX IDX_D0C58FB3B65687BC ON object_character');
        $this->addSql('ALTER TABLE object_character DROP object_effect_id');
    }
}
