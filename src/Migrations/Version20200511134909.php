<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200511134909 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE app_land (id INT AUTO_INCREMENT NOT NULL, naam VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_poule (id INT AUTO_INCREMENT NOT NULL, land1_id INT DEFAULT NULL, land2_id INT DEFAULT NULL, land3_id INT DEFAULT NULL, land4_id INT DEFAULT NULL, naam VARCHAR(255) NOT NULL, INDEX IDX_2CCC668D407C118D (land1_id), INDEX IDX_2CCC668D52C9BE63 (land2_id), INDEX IDX_2CCC668DEA75D906 (land3_id), INDEX IDX_2CCC668D77A2E1BF (land4_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poule_land (poule_id INT NOT NULL, land_id INT NOT NULL, INDEX IDX_5581D6C926596FD8 (poule_id), UNIQUE INDEX UNIQ_5581D6C91994904A (land_id), PRIMARY KEY(poule_id, land_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE app_poule ADD CONSTRAINT FK_2CCC668D407C118D FOREIGN KEY (land1_id) REFERENCES app_land (id)');
        $this->addSql('ALTER TABLE app_poule ADD CONSTRAINT FK_2CCC668D52C9BE63 FOREIGN KEY (land2_id) REFERENCES app_land (id)');
        $this->addSql('ALTER TABLE app_poule ADD CONSTRAINT FK_2CCC668DEA75D906 FOREIGN KEY (land3_id) REFERENCES app_land (id)');
        $this->addSql('ALTER TABLE app_poule ADD CONSTRAINT FK_2CCC668D77A2E1BF FOREIGN KEY (land4_id) REFERENCES app_land (id)');
        $this->addSql('ALTER TABLE poule_land ADD CONSTRAINT FK_5581D6C926596FD8 FOREIGN KEY (poule_id) REFERENCES app_poule (id)');
        $this->addSql('ALTER TABLE poule_land ADD CONSTRAINT FK_5581D6C91994904A FOREIGN KEY (land_id) REFERENCES app_land (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE app_poule DROP FOREIGN KEY FK_2CCC668D407C118D');
        $this->addSql('ALTER TABLE app_poule DROP FOREIGN KEY FK_2CCC668D52C9BE63');
        $this->addSql('ALTER TABLE app_poule DROP FOREIGN KEY FK_2CCC668DEA75D906');
        $this->addSql('ALTER TABLE app_poule DROP FOREIGN KEY FK_2CCC668D77A2E1BF');
        $this->addSql('ALTER TABLE poule_land DROP FOREIGN KEY FK_5581D6C91994904A');
        $this->addSql('ALTER TABLE poule_land DROP FOREIGN KEY FK_5581D6C926596FD8');
        $this->addSql('DROP TABLE app_land');
        $this->addSql('DROP TABLE app_poule');
        $this->addSql('DROP TABLE poule_land');
    }
}
