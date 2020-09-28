<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200226122811 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE studies (id INT AUTO_INCREMENT NOT NULL, content LONGTEXT NOT NULL, name VARCHAR(255) NOT NULL, duration INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE studies_characters (id INT AUTO_INCREMENT NOT NULL, study_id INT DEFAULT NULL, characters_id INT DEFAULT NULL, duration_status INT NOT NULL, status INT NOT NULL, INDEX IDX_6E526BEEE7B003E9 (study_id), INDEX IDX_6E526BEEC70F0E28 (characters_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE studies_characters ADD CONSTRAINT FK_6E526BEEE7B003E9 FOREIGN KEY (study_id) REFERENCES studies (id)');
        $this->addSql('ALTER TABLE studies_characters ADD CONSTRAINT FK_6E526BEEC70F0E28 FOREIGN KEY (characters_id) REFERENCES characters (id)');
        $this->addSql('ALTER TABLE jobs ADD studies_required VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE studies_characters DROP FOREIGN KEY FK_6E526BEEE7B003E9');
        $this->addSql('DROP TABLE studies');
        $this->addSql('DROP TABLE studies_characters');
        $this->addSql('ALTER TABLE jobs DROP studies_required');
    }
}
