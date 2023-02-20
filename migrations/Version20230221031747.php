<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230221031747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE asteroid (id INT AUTO_INCREMENT NOT NULL, name LONGTEXT NOT NULL, reference_id LONGTEXT NOT NULL, date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', speed NUMERIC(13, 3) NOT NULL, is_hazardous TINYINT(1) NOT NULL, INDEX IDX_19DF93B57E225B11 (is_hazardous), INDEX IDX_19DF93B5F26FEF6 (speed), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE asteroid');
    }
}
