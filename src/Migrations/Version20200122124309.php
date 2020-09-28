<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200122124309 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE friend_requests DROP INDEX UNIQ_EC63B01BCD53EDB6, ADD INDEX IDX_EC63B01BCD53EDB6 (receiver_id)');
        $this->addSql('ALTER TABLE friend_requests DROP INDEX UNIQ_EC63B01B13933E7B, ADD INDEX IDX_EC63B01B13933E7B (send_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE friend_requests DROP INDEX IDX_EC63B01B13933E7B, ADD UNIQUE INDEX UNIQ_EC63B01B13933E7B (send_id)');
        $this->addSql('ALTER TABLE friend_requests DROP INDEX IDX_EC63B01BCD53EDB6, ADD UNIQUE INDEX UNIQ_EC63B01BCD53EDB6 (receiver_id)');
    }
}
