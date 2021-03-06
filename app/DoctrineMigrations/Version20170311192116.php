<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170311192116 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE users CHANGE created created DATETIME NOT NULL, CHANGE updated updated DATETIME NOT NULL');
        $this->addSql('ALTER TABLE disciplines CHANGE created created DATETIME NOT NULL, CHANGE updated updated DATETIME NOT NULL');
        $this->addSql('ALTER TABLE semesters CHANGE created created DATETIME NOT NULL, CHANGE updated updated DATETIME NOT NULL');
        $this->addSql('ALTER TABLE environments CHANGE active active DATETIME NOT NULL, CHANGE updated updated DATETIME NOT NULL');
        $this->addSql('ALTER TABLE courses CHANGE created created DATETIME NOT NULL, CHANGE updated updated DATETIME NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE courses CHANGE created created DATE NOT NULL, CHANGE updated updated DATE NOT NULL');
        $this->addSql('ALTER TABLE disciplines CHANGE created created DATE NOT NULL, CHANGE updated updated DATE NOT NULL');
        $this->addSql('ALTER TABLE environments CHANGE active active TINYINT(1) NOT NULL, CHANGE updated updated DATE NOT NULL');
        $this->addSql('ALTER TABLE semesters CHANGE created created DATE NOT NULL, CHANGE updated updated DATE NOT NULL');
        $this->addSql('ALTER TABLE users CHANGE created created DATE NOT NULL, CHANGE updated updated DATE NOT NULL');
    }
}
