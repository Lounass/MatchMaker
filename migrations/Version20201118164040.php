<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201118164040 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE player ADD COLUMN level DOUBLE PRECISION DEFAULT \'1200\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_98197A65F85E0677');
        $this->addSql('CREATE TEMPORARY TABLE __temp__player AS SELECT id, username, roles, password FROM player');
        $this->addSql('DROP TABLE player');
        $this->addSql('CREATE TABLE player (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO player (id, username, roles, password) SELECT id, username, roles, password FROM __temp__player');
        $this->addSql('DROP TABLE __temp__player');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_98197A65F85E0677 ON player (username)');
    }
}
