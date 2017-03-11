<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161211121608 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE schedules (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, discipline_id INT DEFAULT NULL, environment_id INT DEFAULT NULL, semester_id INT DEFAULT NULL, activity VARCHAR(255) DEFAULT NULL, created DATE NOT NULL, active TINYINT(1) NOT NULL, start_time TIME DEFAULT NULL, end_time TIME DEFAULT NULL, week_day INT NOT NULL, updated DATE NOT NULL, INDEX IDX_313BDC8EA76ED395 (user_id), INDEX IDX_313BDC8EA5522701 (discipline_id), INDEX IDX_313BDC8E903E3A94 (environment_id), INDEX IDX_313BDC8E4A798B6F (semester_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE schedules ADD CONSTRAINT FK_313BDC8EA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE schedules ADD CONSTRAINT FK_313BDC8EA5522701 FOREIGN KEY (discipline_id) REFERENCES disciplines (id)');
        $this->addSql('ALTER TABLE schedules ADD CONSTRAINT FK_313BDC8E903E3A94 FOREIGN KEY (environment_id) REFERENCES environments (id)');
        $this->addSql('ALTER TABLE schedules ADD CONSTRAINT FK_313BDC8E4A798B6F FOREIGN KEY (semester_id) REFERENCES semesters (id)');
        $this->addSql('ALTER TABLE users DROP locked, DROP expired, DROP expires_at, DROP credentials_expired, DROP credentials_expire_at, CHANGE salt salt VARCHAR(255) DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE schedules');
        $this->addSql('ALTER TABLE users ADD locked TINYINT(1) NOT NULL, ADD expired TINYINT(1) NOT NULL, ADD expires_at DATETIME DEFAULT NULL, ADD credentials_expired TINYINT(1) NOT NULL, ADD credentials_expire_at DATETIME DEFAULT NULL, CHANGE salt salt VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
