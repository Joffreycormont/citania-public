<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200114150532 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E9616269B11');
        $this->addSql('DROP INDEX IDX_DB021E9616269B11 ON messages');
        $this->addSql('ALTER TABLE messages CHANGE send_id_id send_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E9613933E7B FOREIGN KEY (send_id) REFERENCES characters (id)');
        $this->addSql('CREATE INDEX IDX_DB021E9613933E7B ON messages (send_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E9613933E7B');
        $this->addSql('DROP INDEX IDX_DB021E9613933E7B ON messages');
        $this->addSql('ALTER TABLE messages CHANGE send_id send_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E9616269B11 FOREIGN KEY (send_id_id) REFERENCES characters (id)');
        $this->addSql('CREATE INDEX IDX_DB021E9616269B11 ON messages (send_id_id)');
    }
}
