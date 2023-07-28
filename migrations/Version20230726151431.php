<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230726151431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE analytical_technique (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consumable (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consumable_impact_category (id INT AUTO_INCREMENT NOT NULL, consumable_id INT NOT NULL, impact_category_id INT NOT NULL, value DOUBLE PRECISION DEFAULT NULL, INDEX IDX_CFD18ABCA94ADB61 (consumable_id), INDEX IDX_CFD18ABC80F4936D (impact_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, code VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5373C96677153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE device (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE device_impact_category (id INT AUTO_INCREMENT NOT NULL, device_id INT NOT NULL, impact_category_id INT NOT NULL, value DOUBLE PRECISION DEFAULT NULL, INDEX IDX_94B1D0C394A4C7D4 (device_id), INDEX IDX_94B1D0C380F4936D (impact_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE electricity_impact_category (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, impact_category_id INT NOT NULL, value DOUBLE PRECISION DEFAULT NULL, INDEX IDX_BA7283FDF92F3E70 (country_id), INDEX IDX_BA7283FD80F4936D (impact_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gas (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gas_impact_category (id INT AUTO_INCREMENT NOT NULL, gas_id INT NOT NULL, impact_category_id INT NOT NULL, value DOUBLE PRECISION DEFAULT NULL, INDEX IDX_7CC7F0C9E0EBD3EC (gas_id), INDEX IDX_7CC7F0C980F4936D (impact_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE impact_category (id INT AUTO_INCREMENT NOT NULL, unit VARCHAR(255) DEFAULT NULL, name_fr VARCHAR(255) DEFAULT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_impact_category (id INT AUTO_INCREMENT NOT NULL, media_id INT NOT NULL, impact_category_id INT NOT NULL, value DOUBLE PRECISION DEFAULT NULL, INDEX IDX_5FD71B4AEA9FDD75 (media_id), INDEX IDX_5FD71B4A80F4936D (impact_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE solvent (id INT AUTO_INCREMENT NOT NULL, extra TINYINT(1) DEFAULT 0 NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE solvent_impact_category (id INT AUTO_INCREMENT NOT NULL, solvent_id INT NOT NULL, impact_category_id INT NOT NULL, value DOUBLE PRECISION DEFAULT NULL, INDEX IDX_870663A476B43451 (solvent_id), INDEX IDX_870663A480F4936D (impact_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transport_impact_category (id INT AUTO_INCREMENT NOT NULL, transport_mode_id INT NOT NULL, impact_category_id INT NOT NULL, value DOUBLE PRECISION DEFAULT NULL, INDEX IDX_FDCB4936E33245BB (transport_mode_id), INDEX IDX_FDCB493680F4936D (impact_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transport_mode (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE consumable_impact_category ADD CONSTRAINT FK_CFD18ABCA94ADB61 FOREIGN KEY (consumable_id) REFERENCES consumable (id)');
        $this->addSql('ALTER TABLE consumable_impact_category ADD CONSTRAINT FK_CFD18ABC80F4936D FOREIGN KEY (impact_category_id) REFERENCES impact_category (id)');
        $this->addSql('ALTER TABLE device_impact_category ADD CONSTRAINT FK_94B1D0C394A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id)');
        $this->addSql('ALTER TABLE device_impact_category ADD CONSTRAINT FK_94B1D0C380F4936D FOREIGN KEY (impact_category_id) REFERENCES impact_category (id)');
        $this->addSql('ALTER TABLE electricity_impact_category ADD CONSTRAINT FK_BA7283FDF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE electricity_impact_category ADD CONSTRAINT FK_BA7283FD80F4936D FOREIGN KEY (impact_category_id) REFERENCES impact_category (id)');
        $this->addSql('ALTER TABLE gas_impact_category ADD CONSTRAINT FK_7CC7F0C9E0EBD3EC FOREIGN KEY (gas_id) REFERENCES gas (id)');
        $this->addSql('ALTER TABLE gas_impact_category ADD CONSTRAINT FK_7CC7F0C980F4936D FOREIGN KEY (impact_category_id) REFERENCES impact_category (id)');
        $this->addSql('ALTER TABLE media_impact_category ADD CONSTRAINT FK_5FD71B4AEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE media_impact_category ADD CONSTRAINT FK_5FD71B4A80F4936D FOREIGN KEY (impact_category_id) REFERENCES impact_category (id)');
        $this->addSql('ALTER TABLE solvent_impact_category ADD CONSTRAINT FK_870663A476B43451 FOREIGN KEY (solvent_id) REFERENCES solvent (id)');
        $this->addSql('ALTER TABLE solvent_impact_category ADD CONSTRAINT FK_870663A480F4936D FOREIGN KEY (impact_category_id) REFERENCES impact_category (id)');
        $this->addSql('ALTER TABLE transport_impact_category ADD CONSTRAINT FK_FDCB4936E33245BB FOREIGN KEY (transport_mode_id) REFERENCES transport_mode (id)');
        $this->addSql('ALTER TABLE transport_impact_category ADD CONSTRAINT FK_FDCB493680F4936D FOREIGN KEY (impact_category_id) REFERENCES impact_category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consumable_impact_category DROP FOREIGN KEY FK_CFD18ABCA94ADB61');
        $this->addSql('ALTER TABLE consumable_impact_category DROP FOREIGN KEY FK_CFD18ABC80F4936D');
        $this->addSql('ALTER TABLE device_impact_category DROP FOREIGN KEY FK_94B1D0C394A4C7D4');
        $this->addSql('ALTER TABLE device_impact_category DROP FOREIGN KEY FK_94B1D0C380F4936D');
        $this->addSql('ALTER TABLE electricity_impact_category DROP FOREIGN KEY FK_BA7283FDF92F3E70');
        $this->addSql('ALTER TABLE electricity_impact_category DROP FOREIGN KEY FK_BA7283FD80F4936D');
        $this->addSql('ALTER TABLE gas_impact_category DROP FOREIGN KEY FK_7CC7F0C9E0EBD3EC');
        $this->addSql('ALTER TABLE gas_impact_category DROP FOREIGN KEY FK_7CC7F0C980F4936D');
        $this->addSql('ALTER TABLE media_impact_category DROP FOREIGN KEY FK_5FD71B4AEA9FDD75');
        $this->addSql('ALTER TABLE media_impact_category DROP FOREIGN KEY FK_5FD71B4A80F4936D');
        $this->addSql('ALTER TABLE solvent_impact_category DROP FOREIGN KEY FK_870663A476B43451');
        $this->addSql('ALTER TABLE solvent_impact_category DROP FOREIGN KEY FK_870663A480F4936D');
        $this->addSql('ALTER TABLE transport_impact_category DROP FOREIGN KEY FK_FDCB4936E33245BB');
        $this->addSql('ALTER TABLE transport_impact_category DROP FOREIGN KEY FK_FDCB493680F4936D');
        $this->addSql('DROP TABLE analytical_technique');
        $this->addSql('DROP TABLE consumable');
        $this->addSql('DROP TABLE consumable_impact_category');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE device');
        $this->addSql('DROP TABLE device_impact_category');
        $this->addSql('DROP TABLE electricity_impact_category');
        $this->addSql('DROP TABLE gas');
        $this->addSql('DROP TABLE gas_impact_category');
        $this->addSql('DROP TABLE impact_category');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE media_impact_category');
        $this->addSql('DROP TABLE solvent');
        $this->addSql('DROP TABLE solvent_impact_category');
        $this->addSql('DROP TABLE transport_impact_category');
        $this->addSql('DROP TABLE transport_mode');
    }
}
