<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200208120438 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE job_product_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE object_character (id INT AUTO_INCREMENT NOT NULL, stock_category_id INT DEFAULT NULL, characters_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, quantity INT NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_D0C58FB3CD883BD6 (stock_category_id), INDEX IDX_D0C58FB3C70F0E28 (characters_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_store (id INT AUTO_INCREMENT NOT NULL, store_id INT DEFAULT NULL, product_id INT DEFAULT NULL, quantity INT NOT NULL, price DOUBLE PRECISION NOT NULL, expiration_date DATETIME NOT NULL, is_onsale INT NOT NULL, INDEX IDX_5E0B232BB092A811 (store_id), INDEX IDX_5E0B232B4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE store (id INT AUTO_INCREMENT NOT NULL, job_category_id INT DEFAULT NULL, characters_id INT DEFAULT NULL, sales_number INT NOT NULL, ca DOUBLE PRECISION NOT NULL, lost_ca DOUBLE PRECISION NOT NULL, lost_product INT NOT NULL, INDEX IDX_FF575877712A86AB (job_category_id), INDEX IDX_FF575877C70F0E28 (characters_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE object_character ADD CONSTRAINT FK_D0C58FB3CD883BD6 FOREIGN KEY (stock_category_id) REFERENCES stock_category (id)');
        $this->addSql('ALTER TABLE object_character ADD CONSTRAINT FK_D0C58FB3C70F0E28 FOREIGN KEY (characters_id) REFERENCES characters (id)');
        $this->addSql('ALTER TABLE product_store ADD CONSTRAINT FK_5E0B232BB092A811 FOREIGN KEY (store_id) REFERENCES store (id)');
        $this->addSql('ALTER TABLE product_store ADD CONSTRAINT FK_5E0B232B4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE store ADD CONSTRAINT FK_FF575877712A86AB FOREIGN KEY (job_category_id) REFERENCES job_product_category (id)');
        $this->addSql('ALTER TABLE store ADD CONSTRAINT FK_FF575877C70F0E28 FOREIGN KEY (characters_id) REFERENCES characters (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE store DROP FOREIGN KEY FK_FF575877712A86AB');
        $this->addSql('ALTER TABLE product_store DROP FOREIGN KEY FK_5E0B232B4584665A');
        $this->addSql('ALTER TABLE object_character DROP FOREIGN KEY FK_D0C58FB3CD883BD6');
        $this->addSql('ALTER TABLE product_store DROP FOREIGN KEY FK_5E0B232BB092A811');
        $this->addSql('DROP TABLE job_product_category');
        $this->addSql('DROP TABLE object_character');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_store');
        $this->addSql('DROP TABLE stock_category');
        $this->addSql('DROP TABLE store');
    }
}
