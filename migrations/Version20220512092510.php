<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220512092510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__garden_sales AS SELECT id, plant, price, date FROM garden_sales');
        $this->addSql('DROP TABLE garden_sales');
        $this->addSql('CREATE TABLE garden_sales (id INTEGER NOT NULL, plant VARCHAR(25) NOT NULL, price INTEGER NOT NULL, date VARCHAR(20) NOT NULL, time VARCHAR(10) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO garden_sales (id, plant, price, date) SELECT id, plant, price, date FROM __temp__garden_sales');
        $this->addSql('DROP TABLE __temp__garden_sales');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__garden_sales AS SELECT id, plant, price, date FROM garden_sales');
        $this->addSql('DROP TABLE garden_sales');
        $this->addSql('CREATE TABLE garden_sales (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, plant VARCHAR(25) NOT NULL, price INTEGER NOT NULL, date VARCHAR(20) NOT NULL)');
        $this->addSql('INSERT INTO garden_sales (id, plant, price, date) SELECT id, plant, price, date FROM __temp__garden_sales');
        $this->addSql('DROP TABLE __temp__garden_sales');
    }
}
