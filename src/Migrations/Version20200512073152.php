<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200512073152 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE poule_stemmen DROP FOREIGN KEY FK_16382FFDD1C191DE');
        $this->addSql('DROP TABLE poule_stemmen');
        $this->addSql('DROP TABLE stem');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE poule_stemmen (poule_id INT NOT NULL, stem_id INT NOT NULL, UNIQUE INDEX UNIQ_16382FFDD1C191DE (stem_id), INDEX IDX_16382FFD26596FD8 (poule_id), PRIMARY KEY(poule_id, stem_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE stem (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE poule_stemmen ADD CONSTRAINT FK_16382FFD26596FD8 FOREIGN KEY (poule_id) REFERENCES app_poule (id)');
        $this->addSql('ALTER TABLE poule_stemmen ADD CONSTRAINT FK_16382FFDD1C191DE FOREIGN KEY (stem_id) REFERENCES stem (id)');
    }
}
