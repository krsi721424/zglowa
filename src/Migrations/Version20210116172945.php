<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210116172945 extends AbstractMigration
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
            CREATE SEQUENCE IF NOT EXISTS product_id_seq INCREMENT BY 1 MINVALUE 1 START 1
        SQL);
        $this->addSql(<<<SQL
            DROP TYPE IF EXISTS product_category
        SQL);
        $this->addSql(<<<SQL
            CREATE TYPE product_category AS ENUM (
                'chemia',
                'bio',
                'odzież',
                'budowlane',
                'elektronika',
                'rolnictwo',
                'dla dzieci',
                'motoryzacja',
                'surowce',
                'sport',
                'AGD',
                'RTV',
                'meble',
                'elektryka',
                'inne',
            )
        SQL);
        $this->addSql(<<<SQL
            DROP TYPE IF EXISTS product_subcategory
        SQL);
        $this->addSql(<<<SQL
            CREATE TYPE product_subcategory AS ENUM (
                'farby',
                'kleje',
                'oleje',
                'chemia domowa',
                'inne',
                'żywność',
                'makulatura',
                'odzież męska',
                'odzież damska',
                'odzież dziecięca',
                'narzędzia',
                'odpady budowlane',
                'ciężki sprzęt',
                'komputery',
                'telefony',
                'zegarki',
                'aparaty',
                'maszyny rolnicze',
                'części do maszyn',
                'zabawki',
                'nauka i rozwój',
                'wózki',
                'meble dziecięce',
                'samochody',
                'części motoryzacyjne',
                'akcesoria motoryzacyjne',
                'jednoślady',
                'opony',
                'felgi',
                'odzież sportowa',
                'obuwie sportowe',
                'sprzęt sportowy',
                'akumulatory',
                'baterie',
                'kable',
                'narzędzia elektryczne',
                )
        SQL);
        $this->addSql(<<<SQL
            CREATE TABLE product (
                id INT NOT NULL,
                user_id INT NOT NULL,
                name VARCHAR(255) NOT NULL,
                category product_category NOT NULL,
                subcategory product_subcategory,
                created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
                status VARCHAR(255) NOT NULL,
                updated_at TIMESTAMP(0) WITH TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<SQL
            CREATE INDEX IDX_D34A04AD9D86650F ON product (user_id)
        SQL);
        $this->addSql(<<<SQL
            ALTER TABLE
                product
            ADD CONSTRAINT
                FK_D34A04AD9D86650F FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'postgresql',
            'Migration can only be executed safely on \'postgresql\'.'
        );

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('DROP TABLE product');
    }
}
