<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210130195603 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE app_users_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE product_image_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE product_image (id INT NOT NULL, product_id INT NOT NULL, name VARCHAR(255) NOT NULL, main BOOLEAN DEFAULT false, created_ad TIMESTAMP(0) WITH TIME ZONE NOT NULL, deleted_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_64617F034584665A ON announcement_image (announcement_id)');
        $this->addSql(
            'ALTER TABLE announcement_image ADD CONSTRAINT FK_64617F034584665A FOREIGN KEY (announcement_id) REFERENCES announcement (id) NOT DEFERRABLE INITIALLY IMMEDIATE'
        );
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE product_image_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE app_users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE announcement_image');
        $this->addSql('ALTER TABLE announcement ALTER description DROP NOT NULL');
        $this->addSql('ALTER TABLE announcement ALTER created_at TYPE TIMESTAMP(0) WITH TIME ZONE');
        $this->addSql('ALTER TABLE announcement ALTER created_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE announcement ALTER updated_at TYPE TIMESTAMP(0) WITH TIME ZONE');
        $this->addSql('ALTER TABLE announcement ALTER updated_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER INDEX idx_d34a04ada76ed395 RENAME TO idx_d34a04ad9d86650f');
    }
}
