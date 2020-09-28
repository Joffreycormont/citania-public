<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200131130520 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE characters ADD waste_to_take_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410ED2FED331 FOREIGN KEY (waste_to_take_id) REFERENCES waste_to_take (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3A29410ED2FED331 ON characters (waste_to_take_id)');
        $this->addSql('ALTER TABLE waste_to_take DROP FOREIGN KEY FK_34CB8862C70F0E28');
        $this->addSql('DROP INDEX UNIQ_34CB8862C70F0E28 ON waste_to_take');
        $this->addSql('ALTER TABLE waste_to_take DROP characters_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE characters DROP FOREIGN KEY FK_3A29410ED2FED331');
        $this->addSql('DROP INDEX UNIQ_3A29410ED2FED331 ON characters');
        $this->addSql('ALTER TABLE characters DROP waste_to_take_id');
        $this->addSql('ALTER TABLE waste_to_take ADD characters_id INT NOT NULL');
        $this->addSql('ALTER TABLE waste_to_take ADD CONSTRAINT FK_34CB8862C70F0E28 FOREIGN KEY (characters_id) REFERENCES characters (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_34CB8862C70F0E28 ON waste_to_take (characters_id)');
    }
}
