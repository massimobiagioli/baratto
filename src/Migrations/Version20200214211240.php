<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200214211240 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE token (id INT AUTO_INCREMENT NOT NULL, access_token VARCHAR(255) NOT NULL, id_utente INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE articolo (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, monete INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movimento (id INT AUTO_INCREMENT NOT NULL, venditore_id INT DEFAULT NULL, compratore_id INT DEFAULT NULL, tipo VARCHAR(1) NOT NULL, data_operazione DATETIME NOT NULL, quantita INT NOT NULL, stato VARCHAR(1) NOT NULL, ticket VARCHAR(255) DEFAULT NULL, INDEX IDX_5BE0E915674B66F1 (venditore_id), INDEX IDX_5BE0E915BEF9F7B1 (compratore_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utente (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, amministratore TINYINT(1) NOT NULL, nome VARCHAR(255) NOT NULL, cognome VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movimento ADD CONSTRAINT FK_5BE0E915674B66F1 FOREIGN KEY (venditore_id) REFERENCES utente (id)');
        $this->addSql('ALTER TABLE movimento ADD CONSTRAINT FK_5BE0E915BEF9F7B1 FOREIGN KEY (compratore_id) REFERENCES utente (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE movimento DROP FOREIGN KEY FK_5BE0E915674B66F1');
        $this->addSql('ALTER TABLE movimento DROP FOREIGN KEY FK_5BE0E915BEF9F7B1');
        $this->addSql('DROP TABLE token');
        $this->addSql('DROP TABLE articolo');
        $this->addSql('DROP TABLE movimento');
        $this->addSql('DROP TABLE utente');
    }
}
