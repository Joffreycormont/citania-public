<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200121183521 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE friend_requests CHANGE receiver_id receiver_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE friend_requests ADD CONSTRAINT FK_EC63B01BCD53EDB6 FOREIGN KEY (receiver_id) REFERENCES characters (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EC63B01BCD53EDB6 ON friend_requests (receiver_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE friend_requests DROP FOREIGN KEY FK_EC63B01BCD53EDB6');
        $this->addSql('DROP INDEX UNIQ_EC63B01BCD53EDB6 ON friend_requests');
        $this->addSql('ALTER TABLE friend_requests CHANGE receiver_id receiver_id INT NOT NULL');
    }
}
