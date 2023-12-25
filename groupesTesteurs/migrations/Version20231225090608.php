<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231225090608 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE registration DROP CONSTRAINT fk_62a8a7a7e455fcc0');
        $this->addSql('ALTER TABLE enseignant DROP CONSTRAINT fk_81a72fa1bf396750');
        $this->addSql('DROP TABLE enseignant');
        $this->addSql('ALTER TABLE registration DROP CONSTRAINT FK_62A8A7A7E455FCC0');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT FK_62A8A7A7E455FCC0 FOREIGN KEY (enseignant_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE enseignant (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE enseignant ADD CONSTRAINT fk_81a72fa1bf396750 FOREIGN KEY (id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE registration DROP CONSTRAINT fk_62a8a7a7e455fcc0');
        $this->addSql('ALTER TABLE registration ADD CONSTRAINT fk_62a8a7a7e455fcc0 FOREIGN KEY (enseignant_id) REFERENCES enseignant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
