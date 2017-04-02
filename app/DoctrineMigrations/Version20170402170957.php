<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170402170957 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE accesses (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, environment_id INT DEFAULT NULL, entry_date DATETIME NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, is_out TINYINT(1) NOT NULL, out_date DATETIME DEFAULT NULL, active TINYINT(1) NOT NULL, INDEX IDX_E234CAE2A76ED395 (user_id), INDEX IDX_E234CAE2903E3A94 (environment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accesses ADD CONSTRAINT FK_E234CAE2A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE accesses ADD CONSTRAINT FK_E234CAE2903E3A94 FOREIGN KEY (environment_id) REFERENCES environments (id)');
        $this->addSql('ALTER TABLE schedules CHANGE created created DATETIME NOT NULL, CHANGE updated updated DATETIME NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE accesses');
        $this->addSql('ALTER TABLE schedules CHANGE created created DATE NOT NULL, CHANGE updated updated DATE NOT NULL');
    }
}
