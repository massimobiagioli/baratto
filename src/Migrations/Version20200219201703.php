<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200219201703 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE movimento ADD articolo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE movimento ADD CONSTRAINT FK_5BE0E9158FF10E34 FOREIGN KEY (articolo_id) REFERENCES articolo (id)');
        $this->addSql('CREATE INDEX IDX_5BE0E9158FF10E34 ON movimento (articolo_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE movimento DROP FOREIGN KEY FK_5BE0E9158FF10E34');
        $this->addSql('DROP INDEX IDX_5BE0E9158FF10E34 ON movimento');
        $this->addSql('ALTER TABLE movimento DROP articolo_id');
    }
}
