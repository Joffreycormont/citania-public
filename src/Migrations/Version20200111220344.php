<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200111220344 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE characters (id INT AUTO_INCREMENT NOT NULL, relation_status_id INT DEFAULT NULL, job_id INT DEFAULT NULL, humor_id INT DEFAULT NULL, age SMALLINT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, money DOUBLE PRECISION NOT NULL, diamond INT NOT NULL, life SMALLINT NOT NULL, food SMALLINT NOT NULL, water SMALLINT NOT NULL, sickness SMALLINT NOT NULL, shape SMALLINT NOT NULL, cleanliness SMALLINT NOT NULL, urine SMALLINT NOT NULL, stools SMALLINT NOT NULL, waste SMALLINT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, sexe VARCHAR(255) NOT NULL, visitor INT NOT NULL, die INT DEFAULT NULL, is_window_open INT NOT NULL, kisses INT NOT NULL, punchs INT NOT NULL, hugs INT NOT NULL, pinchs INT NOT NULL, smiles INT NOT NULL, pulled_hair INT NOT NULL, INDEX IDX_3A29410EAE6A2039 (relation_status_id), INDEX IDX_3A29410EBE04EA9 (job_id), INDEX IDX_3A29410E2F4213C6 (humor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE characters_childrens (characters_id INT NOT NULL, childrens_id INT NOT NULL, INDEX IDX_408D07A3C70F0E28 (characters_id), INDEX IDX_408D07A3E84C7936 (childrens_id), PRIMARY KEY(characters_id, childrens_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, characters_id INT DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, send_id INT NOT NULL, send_name VARCHAR(255) NOT NULL, status INT NOT NULL, INDEX IDX_5F9E962AC70F0E28 (characters_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE humor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jobs (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, salary DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE laws (id INT AUTO_INCREMENT NOT NULL, lawcode_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, author_id INT NOT NULL, INDEX IDX_B0D3F9077F6AA08F (lawcode_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE childrens (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, age INT NOT NULL, life INT NOT NULL, food INT NOT NULL, water INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE law_codes (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profils (id INT AUTO_INCREMENT NOT NULL, characters_id INT DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_75831F5EC70F0E28 (characters_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE actions (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE election_candidates (id INT AUTO_INCREMENT NOT NULL, vote_counter INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, candidate_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE friend_requests (id INT AUTO_INCREMENT NOT NULL, receiver_id INT NOT NULL, status INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, send_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE law_articles (id INT AUTO_INCREMENT NOT NULL, laws_id INT DEFAULT NULL, articletype_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_A4565059B9AA0A9F (laws_id), INDEX IDX_A456505956B8FC90 (articletype_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE instructions (id INT AUTO_INCREMENT NOT NULL, judge_id INT NOT NULL, title VARCHAR(255) NOT NULL, plaintiff_id INT NOT NULL, accused_id INT NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE logbook (id INT AUTO_INCREMENT NOT NULL, characters_id INT DEFAULT NULL, content LONGTEXT NOT NULL, INDEX IDX_E96B9310C70F0E28 (characters_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL, receiver_id INT NOT NULL, message LONGTEXT NOT NULL, last INT NOT NULL, created_at DATETIME NOT NULL, send_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE news (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE relation_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE law_article_types (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, characters_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, status INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, is_connected INT DEFAULT NULL, rules_accepted INT DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649C70F0E28 (characters_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410EAE6A2039 FOREIGN KEY (relation_status_id) REFERENCES relation_status (id)');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410EBE04EA9 FOREIGN KEY (job_id) REFERENCES jobs (id)');
        $this->addSql('ALTER TABLE characters ADD CONSTRAINT FK_3A29410E2F4213C6 FOREIGN KEY (humor_id) REFERENCES humor (id)');
        $this->addSql('ALTER TABLE characters_childrens ADD CONSTRAINT FK_408D07A3C70F0E28 FOREIGN KEY (characters_id) REFERENCES characters (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE characters_childrens ADD CONSTRAINT FK_408D07A3E84C7936 FOREIGN KEY (childrens_id) REFERENCES childrens (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AC70F0E28 FOREIGN KEY (characters_id) REFERENCES characters (id)');
        $this->addSql('ALTER TABLE laws ADD CONSTRAINT FK_B0D3F9077F6AA08F FOREIGN KEY (lawcode_id) REFERENCES law_codes (id)');
        $this->addSql('ALTER TABLE profils ADD CONSTRAINT FK_75831F5EC70F0E28 FOREIGN KEY (characters_id) REFERENCES characters (id)');
        $this->addSql('ALTER TABLE law_articles ADD CONSTRAINT FK_A4565059B9AA0A9F FOREIGN KEY (laws_id) REFERENCES laws (id)');
        $this->addSql('ALTER TABLE law_articles ADD CONSTRAINT FK_A456505956B8FC90 FOREIGN KEY (articletype_id) REFERENCES law_article_types (id)');
        $this->addSql('ALTER TABLE logbook ADD CONSTRAINT FK_E96B9310C70F0E28 FOREIGN KEY (characters_id) REFERENCES characters (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649C70F0E28 FOREIGN KEY (characters_id) REFERENCES characters (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE characters_childrens DROP FOREIGN KEY FK_408D07A3C70F0E28');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AC70F0E28');
        $this->addSql('ALTER TABLE profils DROP FOREIGN KEY FK_75831F5EC70F0E28');
        $this->addSql('ALTER TABLE logbook DROP FOREIGN KEY FK_E96B9310C70F0E28');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649C70F0E28');
        $this->addSql('ALTER TABLE characters DROP FOREIGN KEY FK_3A29410E2F4213C6');
        $this->addSql('ALTER TABLE characters DROP FOREIGN KEY FK_3A29410EBE04EA9');
        $this->addSql('ALTER TABLE law_articles DROP FOREIGN KEY FK_A4565059B9AA0A9F');
        $this->addSql('ALTER TABLE characters_childrens DROP FOREIGN KEY FK_408D07A3E84C7936');
        $this->addSql('ALTER TABLE laws DROP FOREIGN KEY FK_B0D3F9077F6AA08F');
        $this->addSql('ALTER TABLE characters DROP FOREIGN KEY FK_3A29410EAE6A2039');
        $this->addSql('ALTER TABLE law_articles DROP FOREIGN KEY FK_A456505956B8FC90');
        $this->addSql('DROP TABLE characters');
        $this->addSql('DROP TABLE characters_childrens');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE humor');
        $this->addSql('DROP TABLE jobs');
        $this->addSql('DROP TABLE laws');
        $this->addSql('DROP TABLE childrens');
        $this->addSql('DROP TABLE law_codes');
        $this->addSql('DROP TABLE profils');
        $this->addSql('DROP TABLE actions');
        $this->addSql('DROP TABLE election_candidates');
        $this->addSql('DROP TABLE friend_requests');
        $this->addSql('DROP TABLE law_articles');
        $this->addSql('DROP TABLE instructions');
        $this->addSql('DROP TABLE logbook');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE test');
        $this->addSql('DROP TABLE relation_status');
        $this->addSql('DROP TABLE law_article_types');
        $this->addSql('DROP TABLE user');
    }
}
