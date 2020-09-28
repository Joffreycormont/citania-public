<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200214100025 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE object_effect ADD life_effect INT NOT NULL, ADD food_effect INT NOT NULL, ADD water_effect INT NOT NULL, ADD shape_effect INT NOT NULL, ADD clean_effect INT NOT NULL, ADD urine_effect INT NOT NULL, ADD stools_effect INT NOT NULL, ADD waste_effect INT NOT NULL, ADD sickness_effect INT NOT NULL, DROP gain, DROP lose');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE object_effect ADD gain INT NOT NULL, ADD lose INT NOT NULL, DROP life_effect, DROP food_effect, DROP water_effect, DROP shape_effect, DROP clean_effect, DROP urine_effect, DROP stools_effect, DROP waste_effect, DROP sickness_effect');
    }
}
