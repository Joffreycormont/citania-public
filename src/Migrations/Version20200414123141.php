<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200414123141 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE pharmacy (id INT AUTO_INCREMENT NOT NULL, characters_id INT DEFAULT NULL, money DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_D6C15C1EC70F0E28 (characters_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pharmacy_treatment_stock (id INT AUTO_INCREMENT NOT NULL, pharmacy_id INT DEFAULT NULL, treatment_id INT DEFAULT NULL, stock_quantity INT NOT NULL, INDEX IDX_797E38F8A94ABE2 (pharmacy_id), INDEX IDX_797E38F471C0366 (treatment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pharmacy ADD CONSTRAINT FK_D6C15C1EC70F0E28 FOREIGN KEY (characters_id) REFERENCES characters (id)');
        $this->addSql('ALTER TABLE pharmacy_treatment_stock ADD CONSTRAINT FK_797E38F8A94ABE2 FOREIGN KEY (pharmacy_id) REFERENCES pharmacy (id)');
        $this->addSql('ALTER TABLE pharmacy_treatment_stock ADD CONSTRAINT FK_797E38F471C0366 FOREIGN KEY (treatment_id) REFERENCES treatment (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE pharmacy_treatment_stock DROP FOREIGN KEY FK_797E38F8A94ABE2');
        $this->addSql('DROP TABLE pharmacy');
        $this->addSql('DROP TABLE pharmacy_treatment_stock');
    }
}
