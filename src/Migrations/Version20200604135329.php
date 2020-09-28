<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200604135329 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sports (id INT AUTO_INCREMENT NOT NULL, sports_equipment_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, effect_on_physic INT NOT NULL, INDEX IDX_73C9F91C3B276C9D (sports_equipment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sports_equipment (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, price INT NOT NULL, client_amount_to_unlock INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sports_equipment_sports_room (sports_equipment_id INT NOT NULL, sports_room_id INT NOT NULL, INDEX IDX_4D8ACCC03B276C9D (sports_equipment_id), INDEX IDX_4D8ACCC072381FE3 (sports_room_id), PRIMARY KEY(sports_equipment_id, sports_room_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sports_room (id INT AUTO_INCREMENT NOT NULL, coach_id INT NOT NULL, price_sub INT NOT NULL, price_consult INT NOT NULL, client_amount INT NOT NULL, UNIQUE INDEX UNIQ_EBA885D43C105691 (coach_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sports ADD CONSTRAINT FK_73C9F91C3B276C9D FOREIGN KEY (sports_equipment_id) REFERENCES sports_equipment (id)');
        $this->addSql('ALTER TABLE sports_equipment_sports_room ADD CONSTRAINT FK_4D8ACCC03B276C9D FOREIGN KEY (sports_equipment_id) REFERENCES sports_equipment (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sports_equipment_sports_room ADD CONSTRAINT FK_4D8ACCC072381FE3 FOREIGN KEY (sports_room_id) REFERENCES sports_room (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sports_room ADD CONSTRAINT FK_EBA885D43C105691 FOREIGN KEY (coach_id) REFERENCES characters (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sports DROP FOREIGN KEY FK_73C9F91C3B276C9D');
        $this->addSql('ALTER TABLE sports_equipment_sports_room DROP FOREIGN KEY FK_4D8ACCC03B276C9D');
        $this->addSql('ALTER TABLE sports_equipment_sports_room DROP FOREIGN KEY FK_4D8ACCC072381FE3');
        $this->addSql('DROP TABLE sports');
        $this->addSql('DROP TABLE sports_equipment');
        $this->addSql('DROP TABLE sports_equipment_sports_room');
        $this->addSql('DROP TABLE sports_room');
    }
}
