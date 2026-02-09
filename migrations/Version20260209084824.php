<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260209084824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actualite CHANGE images images VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE evenement CHANGE images images VARCHAR(255) DEFAULT NULL, CHANGE horaire horaire TIME NOT NULL');
        $this->addSql('ALTER TABLE photo CHANGE titre titre VARCHAR(255) DEFAULT NULL, CHANGE cheminImage cheminImage VARCHAR(255) DEFAULT NULL, CHANGE datePhoto datePhoto DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE produit CHANGE image image VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actualite CHANGE images images VARCHAR(255) DEFAULT \'\'\'Logo_60ans.png\'\'\'');
        $this->addSql('ALTER TABLE evenement CHANGE images images VARCHAR(255) DEFAULT \'\'\'Logo_60ans.png\'\'\' NOT NULL, CHANGE horaire horaire TIME DEFAULT \'\'\'00:00:00\'\'\' NOT NULL');
        $this->addSql('ALTER TABLE photo CHANGE titre titre VARCHAR(255) DEFAULT \'NULL\', CHANGE cheminImage cheminImage VARCHAR(255) DEFAULT \'NULL\', CHANGE datePhoto datePhoto DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE produit CHANGE image image VARCHAR(800) DEFAULT \'\'\'Logo_60ans.png\'\'\' NOT NULL');
    }
}
