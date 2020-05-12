<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200512082138 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE poule_land');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE poule_land (poule_id INT NOT NULL, land_id INT NOT NULL, UNIQUE INDEX UNIQ_5581D6C91994904A (land_id), INDEX IDX_5581D6C926596FD8 (poule_id), PRIMARY KEY(poule_id, land_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE poule_land ADD CONSTRAINT FK_5581D6C91994904A FOREIGN KEY (land_id) REFERENCES app_land (id)');
        $this->addSql('ALTER TABLE poule_land ADD CONSTRAINT FK_5581D6C926596FD8 FOREIGN KEY (poule_id) REFERENCES app_poule (id)');
    }
}
