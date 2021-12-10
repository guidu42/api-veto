<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211209154104 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal_breed (animal_id INT NOT NULL, breed_id INT NOT NULL, INDEX IDX_D95C51BB8E962C16 (animal_id), INDEX IDX_D95C51BBA8B4A30F (breed_id), PRIMARY KEY(animal_id, breed_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE breed (id INT AUTO_INCREMENT NOT NULL, species_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_F8AF884FB2A1D860 (species_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal_breed ADD CONSTRAINT FK_D95C51BB8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE animal_breed ADD CONSTRAINT FK_D95C51BBA8B4A30F FOREIGN KEY (breed_id) REFERENCES breed (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE breed ADD CONSTRAINT FK_F8AF884FB2A1D860 FOREIGN KEY (species_id) REFERENCES species (id)');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FB2A1D860');
        $this->addSql('DROP INDEX IDX_6AAB231FB2A1D860 ON animal');
        $this->addSql('ALTER TABLE animal DROP species_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal_breed DROP FOREIGN KEY FK_D95C51BBA8B4A30F');
        $this->addSql('DROP TABLE animal_breed');
        $this->addSql('DROP TABLE breed');
        $this->addSql('ALTER TABLE animal ADD species_id INT NOT NULL');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FB2A1D860 FOREIGN KEY (species_id) REFERENCES species (id)');
        $this->addSql('CREATE INDEX IDX_6AAB231FB2A1D860 ON animal (species_id)');
    }
}
