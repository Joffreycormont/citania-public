<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200323172558 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE studies_test (id INT AUTO_INCREMENT NOT NULL, study_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_AFF174D9E7B003E9 (study_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test_answers (id INT AUTO_INCREMENT NOT NULL, question_id INT DEFAULT NULL, content VARCHAR(255) NOT NULL, is_good_answer INT NOT NULL, INDEX IDX_8C9112CE1E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE test_questions (id INT AUTO_INCREMENT NOT NULL, test_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_841C31F1E5D0459 (test_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE studies_test ADD CONSTRAINT FK_AFF174D9E7B003E9 FOREIGN KEY (study_id) REFERENCES studies (id)');
        $this->addSql('ALTER TABLE test_answers ADD CONSTRAINT FK_8C9112CE1E27F6BF FOREIGN KEY (question_id) REFERENCES test_questions (id)');
        $this->addSql('ALTER TABLE test_questions ADD CONSTRAINT FK_841C31F1E5D0459 FOREIGN KEY (test_id) REFERENCES studies_test (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE test_questions DROP FOREIGN KEY FK_841C31F1E5D0459');
        $this->addSql('ALTER TABLE test_answers DROP FOREIGN KEY FK_8C9112CE1E27F6BF');
        $this->addSql('DROP TABLE studies_test');
        $this->addSql('DROP TABLE test_answers');
        $this->addSql('DROP TABLE test_questions');
    }
}
