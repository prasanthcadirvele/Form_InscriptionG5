<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240122142958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registration DROP CONSTRAINT fk_62a8a7a7e455fcc0');
        $this->addSql('DROP SEQUENCE enseignant_id_seq CASCADE');
        $this->addSql('ALTER TABLE enseignant DROP CONSTRAINT fk_81a72fa1ff631228');
        $this->addSql('DROP TABLE enseignant');
        $this->addSql('ALTER TABLE registration DROP CONSTRAINT FK_62A8A7A7E455FCC0');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A7E455FCC0 FOREIGN KEY (enseignant_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" DROP email');
        $this->addSql('ALTER TABLE "user" DROP password');
        $this->addSql('ALTER TABLE "user" DROP first_name');
        $this->addSql('ALTER TABLE "user" DROP last_name');
        $this->addSql('ALTER TABLE "user" DROP is_validated');
        $this->addSql('ALTER TABLE "user" DROP token');
        $this->addSql('ALTER TABLE "user" DROP token_expires_at');
        $this->addSql('ALTER TABLE "user" DROP user_type');
        $this->addSql('ALTER TABLE "user" ALTER id TYPE VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE enseignant_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE enseignant (id VARCHAR(255) NOT NULL, etablissement_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_81a72fa1ff631228 ON enseignant (etablissement_id)');
        $this->addSql('ALTER TABLE enseignant ADD CONSTRAINT fk_81a72fa1ff631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD password VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD first_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD last_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD is_validated BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD token VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD token_expires_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD user_type VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER id TYPE INT');
        $this->addSql('COMMENT ON COLUMN "user".token_expires_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE registration DROP CONSTRAINT fk_62a8a7a7e455fcc0');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT fk_62a8a7a7e455fcc0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
