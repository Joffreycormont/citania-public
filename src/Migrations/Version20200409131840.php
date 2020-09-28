<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200409131840 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE disease_character (id INT AUTO_INCREMENT NOT NULL, disease_id INT DEFAULT NULL, characters_id INT DEFAULT NULL, disease_discover_status INT NOT NULL, INDEX IDX_AE39404ED8355341 (disease_id), INDEX IDX_AE39404EC70F0E28 (characters_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE diseases (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, effect_on_life INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, doctor_id INT DEFAULT NULL, have_subscription INT NOT NULL, INDEX IDX_1ADAD7EB6B899279 (patient_id), INDEX IDX_1ADAD7EB87F4FB17 (doctor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE treatment (id INT AUTO_INCREMENT NOT NULL, disease_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_98013C31D8355341 (disease_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE disease_character ADD CONSTRAINT FK_AE39404ED8355341 FOREIGN KEY (disease_id) REFERENCES diseases (id)');
        $this->addSql('ALTER TABLE disease_character ADD CONSTRAINT FK_AE39404EC70F0E28 FOREIGN KEY (characters_id) REFERENCES characters (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB6B899279 FOREIGN KEY (patient_id) REFERENCES characters (id)');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EB87F4FB17 FOREIGN KEY (doctor_id) REFERENCES characters (id)');
        $this->addSql('ALTER TABLE treatment ADD CONSTRAINT FK_98013C31D8355341 FOREIGN KEY (disease_id) REFERENCES diseases (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE disease_character DROP FOREIGN KEY FK_AE39404ED8355341');
        $this->addSql('ALTER TABLE treatment DROP FOREIGN KEY FK_98013C31D8355341');
        $this->addSql('DROP TABLE disease_character');
        $this->addSql('DROP TABLE diseases');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE treatment');
    }
}
