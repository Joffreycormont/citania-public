<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200127141626 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE logbook ADD send_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE logbook ADD CONSTRAINT FK_E96B931013933E7B FOREIGN KEY (send_id) REFERENCES characters (id)');
        $this->addSql('CREATE INDEX IDX_E96B931013933E7B ON logbook (send_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE logbook DROP FOREIGN KEY FK_E96B931013933E7B');
        $this->addSql('DROP INDEX IDX_E96B931013933E7B ON logbook');
        $this->addSql('ALTER TABLE logbook DROP send_id');
    }
}
