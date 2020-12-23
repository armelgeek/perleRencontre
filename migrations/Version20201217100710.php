<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201217100710 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, sender_id INT DEFAULT NULL, receiver_id INT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, message LONGTEXT DEFAULT NULL, chapitre INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_B6BD307FF624B39D (sender_id), INDEX IDX_B6BD307FCD53EDB6 (receiver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_bourse (id INT AUTO_INCREMENT NOT NULL, sender_id INT DEFAULT NULL, receiver_id INT DEFAULT NULL, bourse INT NOT NULL, is_accepted TINYINT(1) DEFAULT NULL, is_expired TINYINT(1) DEFAULT NULL, expired_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_EAE52113F624B39D (sender_id), INDEX IDX_EAE52113CD53EDB6 (receiver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_perle (id INT AUTO_INCREMENT NOT NULL, sender_id INT DEFAULT NULL, receiver_id INT NOT NULL, perle INT NOT NULL, is_accepted TINYINT(1) DEFAULT NULL, is_expired TINYINT(1) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_6F4BE24AF624B39D (sender_id), INDEX IDX_6F4BE24ACD53EDB6 (receiver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mon_coffre (id INT AUTO_INCREMENT NOT NULL, profil_id INT DEFAULT NULL, abonnement_id INT DEFAULT NULL, expired_at DATETIME DEFAULT NULL, is_expired TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME NOT NULL, INDEX IDX_B3718E92275ED078 (profil_id), INDEX IDX_B3718E92F1D74413 (abonnement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mon_profil (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, perle INT DEFAULT NULL, point INT DEFAULT NULL, cadeau INT DEFAULT NULL, UNIQUE INDEX UNIQ_3A19120A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FCD53EDB6 FOREIGN KEY (receiver_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE message_bourse ADD CONSTRAINT FK_EAE52113F624B39D FOREIGN KEY (sender_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE message_bourse ADD CONSTRAINT FK_EAE52113CD53EDB6 FOREIGN KEY (receiver_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE message_perle ADD CONSTRAINT FK_6F4BE24AF624B39D FOREIGN KEY (sender_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE message_perle ADD CONSTRAINT FK_6F4BE24ACD53EDB6 FOREIGN KEY (receiver_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE mon_coffre ADD CONSTRAINT FK_B3718E92275ED078 FOREIGN KEY (profil_id) REFERENCES mon_profil (id)');
        $this->addSql('ALTER TABLE mon_coffre ADD CONSTRAINT FK_B3718E92F1D74413 FOREIGN KEY (abonnement_id) REFERENCES abonnement (id)');
        $this->addSql('ALTER TABLE mon_profil ADD CONSTRAINT FK_3A19120A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
        $this->addSql('DROP TABLE abonnement_command');
        $this->addSql('DROP TABLE mon_perle');
        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY FK_351268BBFB88E14F');
        $this->addSql('DROP INDEX UNIQ_351268BBFB88E14F ON abonnement');
        $this->addSql('ALTER TABLE abonnement ADD name LONGTEXT DEFAULT NULL, ADD price DOUBLE PRECISION DEFAULT NULL, ADD perle INT DEFAULT NULL, DROP utilisateur_id, DROP type, CHANGE expired_at updated_at DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mon_coffre DROP FOREIGN KEY FK_B3718E92275ED078');
        $this->addSql('CREATE TABLE abonnement_command (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, price INT NOT NULL, is_valid TINYINT(1) NOT NULL, create_at DATETIME NOT NULL, INDEX IDX_EE9857BCFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE mon_perle (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, perle INT DEFAULT NULL, point INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_3270A76CFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE abonnement_command ADD CONSTRAINT FK_EE9857BCFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE mon_perle ADD CONSTRAINT FK_3270A76CFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE message_bourse');
        $this->addSql('DROP TABLE message_perle');
        $this->addSql('DROP TABLE mon_coffre');
        $this->addSql('DROP TABLE mon_profil');
        $this->addSql('ALTER TABLE abonnement ADD utilisateur_id INT NOT NULL, ADD type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP name, DROP price, DROP perle, CHANGE updated_at expired_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BBFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_351268BBFB88E14F ON abonnement (utilisateur_id)');
    }
}
