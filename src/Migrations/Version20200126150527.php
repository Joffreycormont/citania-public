<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200126150527 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE has_action (id INT AUTO_INCREMENT NOT NULL, action_id INT DEFAULT NULL, send_id INT DEFAULT NULL, receiver_id INT DEFAULT NULL, INDEX IDX_6BEE9B099D32F035 (action_id), INDEX IDX_6BEE9B0913933E7B (send_id), INDEX IDX_6BEE9B09CD53EDB6 (receiver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE has_action ADD CONSTRAINT FK_6BEE9B099D32F035 FOREIGN KEY (action_id) REFERENCES actions (id)');
        $this->addSql('ALTER TABLE has_action ADD CONSTRAINT FK_6BEE9B0913933E7B FOREIGN KEY (send_id) REFERENCES characters (id)');
        $this->addSql('ALTER TABLE has_action ADD CONSTRAINT FK_6BEE9B09CD53EDB6 FOREIGN KEY (receiver_id) REFERENCES characters (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE has_action');
    }
}
