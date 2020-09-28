<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200214105312 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE object_effect ADD loose_life_effect INT NOT NULL, ADD loose_food_effect INT NOT NULL, ADD loose_water_effect INT NOT NULL, ADD loose_shape_effect INT NOT NULL, ADD loose_clean_effect INT NOT NULL, ADD loose_urine_effect INT NOT NULL, ADD loose_stools_effect INT NOT NULL, ADD loose_waste_effect INT NOT NULL, ADD loose_sickness_effect INT NOT NULL, DROP lose_life_effect, DROP lose_food_effect, DROP lose_water_effect, DROP lose_shape_effect, DROP lose_clean_effect, DROP lose_urine_effect, DROP lose_stools_effect, DROP lose_waste_effect, DROP lose_sickness_effect');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE object_effect ADD lose_life_effect INT NOT NULL, ADD lose_food_effect INT NOT NULL, ADD lose_water_effect INT NOT NULL, ADD lose_shape_effect INT NOT NULL, ADD lose_clean_effect INT NOT NULL, ADD lose_urine_effect INT NOT NULL, ADD lose_stools_effect INT NOT NULL, ADD lose_waste_effect INT NOT NULL, ADD lose_sickness_effect INT NOT NULL, DROP loose_life_effect, DROP loose_food_effect, DROP loose_water_effect, DROP loose_shape_effect, DROP loose_clean_effect, DROP loose_urine_effect, DROP loose_stools_effect, DROP loose_waste_effect, DROP loose_sickness_effect');
    }
}
