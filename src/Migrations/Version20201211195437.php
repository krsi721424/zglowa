<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20201211195437 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql(<<<SQL
            CREATE SEQUENCE IF NOT EXISTS user_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<SQL
            CREATE TABLE "user" (
                id INT NOT NULL,
                email VARCHAR(255) NOT NULL,
                username VARCHAR(255) NOT NULL,
                password VARCHAR(64) NOT NULL,
                roles TEXT NOT NULL,
                PRIMARY KEY(id)
            )
        SQL);
        $this->addSql(<<<SQL
            CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)
        SQL);
        $this->addSql(<<<SQL
            CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON "user" (username)
        SQL);
        $this->addSql(<<<SQL
            COMMENT ON COLUMN "user".roles IS '(DC2Type:array)'
        SQL);
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
           'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql(<<<SQL
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<SQL
            DROP SEQUENCE user_id_seq CASCADE
        SQL);
        $this->addSql(<<<SQL
            DROP TABLE "user"
        SQL);
    }
}
