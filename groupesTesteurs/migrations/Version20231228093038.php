<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231228093038 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE etablissement_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE groupe_testeurs_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE registration_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE etablissement (id INT NOT NULL, uai VARCHAR(255) NOT NULL, etablissement_name VARCHAR(255) NOT NULL, etablissement_type VARCHAR(255) NOT NULL, etablissement_adress TEXT NOT NULL, etablissement_departement INT NOT NULL, etablissement_code_postal INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE groupe_testeurs (id INT NOT NULL, group_testeur_label VARCHAR(255) NOT NULL, group_testeur_description TEXT NOT NULL, created_at DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE registration (id INT NOT NULL, groupe_testeurs_id INT DEFAULT NULL, enseignant_id INT DEFAULT NULL, registration_date DATE NOT NULL, is_registration_validated BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_62A8A7A79DA213D2 ON registration (groupe_testeurs_id)');
        $this->addSql('CREATE INDEX IDX_62A8A7A7E455FCC0 ON registration (enseignant_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, etablissement_id INT DEFAULT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, is_validated BOOLEAN NOT NULL, token VARCHAR(255) DEFAULT NULL, token_expires_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, user_type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8D93D649FF631228 ON "user" (etablissement_id)');
        $this->addSql('COMMENT ON COLUMN "user".token_expires_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A79DA213D2 FOREIGN KEY (groupe_testeurs_id) REFERENCES groupe_testeurs (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A7E455FCC0 FOREIGN KEY (enseignant_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649FF631228 FOREIGN KEY (etablissement_id) REFERENCES etablissement (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE etablissement_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE groupe_testeurs_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE registration_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE registration DROP CONSTRAINT FK_62A8A7A79DA213D2');
        $this->addSql('ALTER TABLE registration DROP CONSTRAINT FK_62A8A7A7E455FCC0');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649FF631228');
        $this->addSql('DROP TABLE etablissement');
        $this->addSql('DROP TABLE groupe_testeurs');
        $this->addSql('DROP TABLE registration');
        $this->addSql('DROP TABLE "user"');
    }
}
