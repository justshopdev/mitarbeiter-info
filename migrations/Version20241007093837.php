<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241007093837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
                 CREATE TABLE news (
                     id          SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
                     created     DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
                     updated     DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
                     title       VARCHAR(64) NOT NULL,
                     text        JSON NOT NULL,
                     PRIMARY KEY (id)
                    ) COMMENT 'news content'
SQL;

        $sql2 = <<<SQL
                 CREATE TABLE news_attachment (
                     id          SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
                     created     DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
                     updated     DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
                     news_id     SMALLINT UNSIGNED NOT NULL,
                     lable       VARCHAR(64) NOT NULL,
                     type        VARCHAR(24) NOT NULL,
                     dirname     VARCHAR(255) NOT NULL,
                     filename    VARCHAR(255) NOT NULL,
                     filetype    VARCHAR(24) NOT NULL,
                     filesize    INTEGER UNSIGNED NOT NULL,
                     PRIMARY KEY (id),
                     FOREIGN KEY (news_id) REFERENCES news(id)
                    ) COMMENT 'news attachment files'
SQL;

        $sql3 = <<<SQL
                 CREATE TABLE news_recipients (
                     id          SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
                     created     DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
                     updated     DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
                     news_id     SMALLINT UNSIGNED NOT NULL,
                     email       VARCHAR(255) NOT NULL,
                     status      VARCHAR(24) NOT NULL,
                     PRIMARY KEY (id),
                     FOREIGN KEY (news_id) REFERENCES news(id)
                    ) COMMENT 'news recipients and status'
SQL;

        $this->addSql($sql);
        $this->addSql($sql2);
        $this->addSql($sql3);
    }

    public function down(Schema $schema): void
    {
    }
}
