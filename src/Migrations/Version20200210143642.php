<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200210143642 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE house_furniture (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, gain_capacity INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE house_furniture_characters (house_furniture_id INT NOT NULL, characters_id INT NOT NULL, INDEX IDX_D05460662FD53BC (house_furniture_id), INDEX IDX_D0546066C70F0E28 (characters_id), PRIMARY KEY(house_furniture_id, characters_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE house_furniture_characters ADD CONSTRAINT FK_D05460662FD53BC FOREIGN KEY (house_furniture_id) REFERENCES house_furniture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE house_furniture_characters ADD CONSTRAINT FK_D0546066C70F0E28 FOREIGN KEY (characters_id) REFERENCES characters (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE house_furniture_characters DROP FOREIGN KEY FK_D05460662FD53BC');
        $this->addSql('DROP TABLE house_furniture');
        $this->addSql('DROP TABLE house_furniture_characters');
    }
}
