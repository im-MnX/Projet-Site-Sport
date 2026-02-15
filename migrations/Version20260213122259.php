<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260213122259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actualite CHANGE images images VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE document CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE evenement ADD brochure_filename VARCHAR(255) DEFAULT NULL, CHANGE images images VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE photo CHANGE titre titre VARCHAR(255) DEFAULT NULL, CHANGE cheminImage cheminImage VARCHAR(255) DEFAULT NULL, CHANGE datePhoto datePhoto DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE produit CHANGE image image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE utilisateur CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE actualite CHANGE images images VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE document CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE evenement DROP brochure_filename, CHANGE images images VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE photo CHANGE titre titre VARCHAR(255) DEFAULT \'NULL\', CHANGE cheminImage cheminImage VARCHAR(255) DEFAULT \'NULL\', CHANGE datePhoto datePhoto DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE produit CHANGE image image VARCHAR(255) DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE utilisateur CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_bin`');
    }
}
