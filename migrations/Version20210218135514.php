<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210218135514 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abonnement (id INT AUTO_INCREMENT NOT NULL, name LONGTEXT DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, perle INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, duration INT DEFAULT NULL, access JSON DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE album (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, privat TINYINT(1) NOT NULL, INDEX IDX_39986E43FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE autorised_user (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, receiver_id INT DEFAULT NULL, is_autorised TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, expired_at DATETIME DEFAULT NULL, perle INT DEFAULT NULL, INDEX IDX_FF0E8B12A76ED395 (user_id), INDEX IDX_FF0E8B12CD53EDB6 (receiver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cadeau (id INT AUTO_INCREMENT NOT NULL, price INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, sent INT DEFAULT NULL, number INT DEFAULT NULL, image LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cadeau_sent (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, cadeau_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_52FD2660A76ED395 (user_id), INDEX IDX_52FD2660D9D5ED84 (cadeau_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, commented_id INT NOT NULL, commenter_id INT NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_9474526CC1A7A1A1 (commented_id), INDEX IDX_9474526CB4D5A9E2 (commenter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conversation (id INT AUTO_INCREMENT NOT NULL, uti_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, last_message_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_8A8E26E93951DF75 (uti_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_C1765B6398260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, album_id INT NOT NULL, utilisateur_id INT DEFAULT NULL, imagepath VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_C53D045F1137ABCF (album_id), INDEX IDX_C53D045FFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, uti_id INT NOT NULL, conv_id INT NOT NULL, type VARCHAR(255) DEFAULT NULL, message LONGTEXT DEFAULT NULL, chapitre INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_B6BD307F3951DF75 (uti_id), INDEX IDX_B6BD307F2FC61EC7 (conv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_bourse (id INT AUTO_INCREMENT NOT NULL, sender_id INT DEFAULT NULL, receiver_id INT DEFAULT NULL, bourse INT NOT NULL, is_accepted TINYINT(1) DEFAULT NULL, is_expired TINYINT(1) DEFAULT NULL, expired_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, is_refused TINYINT(1) DEFAULT NULL, INDEX IDX_EAE52113F624B39D (sender_id), INDEX IDX_EAE52113CD53EDB6 (receiver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_perle (id INT AUTO_INCREMENT NOT NULL, sender_id INT DEFAULT NULL, receiver_id INT NOT NULL, perle INT NOT NULL, is_accepted TINYINT(1) DEFAULT NULL, is_expired TINYINT(1) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, is_refused TINYINT(1) DEFAULT NULL, expired_at DATETIME DEFAULT NULL, INDEX IDX_6F4BE24AF624B39D (sender_id), INDEX IDX_6F4BE24ACD53EDB6 (receiver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mon_coffre (id INT AUTO_INCREMENT NOT NULL, profil_id INT DEFAULT NULL, abonnement_id INT DEFAULT NULL, expired_at DATETIME DEFAULT NULL, is_expired TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME NOT NULL, validation_number INT DEFAULT NULL, customer_id VARCHAR(255) DEFAULT NULL, transcation JSON DEFAULT NULL, INDEX IDX_B3718E92275ED078 (profil_id), INDEX IDX_B3718E92F1D74413 (abonnement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mon_envie (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, envie_du_jour VARCHAR(255) NOT NULL, date_du_jour DATETIME NOT NULL, INDEX IDX_370F6406FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mon_profil (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, perle INT DEFAULT NULL, point INT DEFAULT NULL, cadeau INT DEFAULT NULL, UNIQUE INDEX UNIQ_3A19120A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, receiver_id INT DEFAULT NULL, messsage LONGTEXT DEFAULT NULL, type VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, title VARCHAR(255) DEFAULT NULL, INDEX IDX_BF5476CACD53EDB6 (receiver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participant (id INT AUTO_INCREMENT NOT NULL, conv_id INT NOT NULL, uti_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_D79F6B112FC61EC7 (conv_id), INDEX IDX_D79F6B113951DF75 (uti_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pays (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo_couverture (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, image_name VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_30713308FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, pays_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_F62F176A6E44244 (pays_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, departement_id INT DEFAULT NULL, region_id INT DEFAULT NULL, pays_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, genre TINYINT(1) DEFAULT NULL, je_cherche JSON DEFAULT NULL, date_naissance DATETIME DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, age INT DEFAULT NULL, couleur_de_cheveux JSON NOT NULL, degaine JSON DEFAULT NULL, sexualite JSON DEFAULT NULL, taille INT DEFAULT NULL, style_de_cheveux JSON DEFAULT NULL, silouhette JSON DEFAULT NULL, j_ai_un_faible_pour JSON DEFAULT NULL, poids INT DEFAULT NULL, couleur_des_yeux VARCHAR(255) DEFAULT NULL, origines JSON DEFAULT NULL, j_aime_porter_ou_pas JSON DEFAULT NULL, je_frissone_pour JSON DEFAULT NULL, passions_au_lit VARCHAR(255) DEFAULT NULL, proffessions JSON DEFAULT NULL, sports JSON DEFAULT NULL, hobbies JSON DEFAULT NULL, alcool JSON DEFAULT NULL, tabac JSON DEFAULT NULL, alimentation JSON DEFAULT NULL, j_aime_manger JSON DEFAULT NULL, scolarite JSON DEFAULT NULL, langues JSON DEFAULT NULL, signe_astrologique JSON DEFAULT NULL, avec_ou_sans_enfant TINYINT(1) DEFAULT NULL, gout_musicaux JSON DEFAULT NULL, religions JSON DEFAULT NULL, personalite JSON DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) DEFAULT NULL, adresse LONGTEXT DEFAULT NULL, certifie TINYINT(1) NOT NULL, condition_generale TINYINT(1) NOT NULL, condition_vente TINYINT(1) NOT NULL, peut_envoyer_mail_depuis_le_site TINYINT(1) NOT NULL, is_online TINYINT(1) DEFAULT NULL, profileimage VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3F85E0677 (username), INDEX IDX_1D1C63B3CCF9E01E (departement_id), INDEX IDX_1D1C63B398260155 (region_id), INDEX IDX_1D1C63B3A6E44244 (pays_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, videopath VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, title VARCHAR(255) NOT NULL, privat TINYINT(1) NOT NULL, INDEX IDX_7CC7DA2CFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video_like (video_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_ABF41D6F29C1004E (video_id), INDEX IDX_ABF41D6FFB88E14F (utilisateur_id), PRIMARY KEY(video_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video_utilisateur (video_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_3F9ED21229C1004E (video_id), INDEX IDX_3F9ED212FB88E14F (utilisateur_id), PRIMARY KEY(video_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E43FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE autorised_user ADD CONSTRAINT FK_FF0E8B12A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE autorised_user ADD CONSTRAINT FK_FF0E8B12CD53EDB6 FOREIGN KEY (receiver_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE cadeau_sent ADD CONSTRAINT FK_52FD2660A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE cadeau_sent ADD CONSTRAINT FK_52FD2660D9D5ED84 FOREIGN KEY (cadeau_id) REFERENCES cadeau (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CC1A7A1A1 FOREIGN KEY (commented_id) REFERENCES video (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CB4D5A9E2 FOREIGN KEY (commenter_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E93951DF75 FOREIGN KEY (uti_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B6398260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F1137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F3951DF75 FOREIGN KEY (uti_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F2FC61EC7 FOREIGN KEY (conv_id) REFERENCES conversation (id)');
        $this->addSql('ALTER TABLE message_bourse ADD CONSTRAINT FK_EAE52113F624B39D FOREIGN KEY (sender_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE message_bourse ADD CONSTRAINT FK_EAE52113CD53EDB6 FOREIGN KEY (receiver_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE message_perle ADD CONSTRAINT FK_6F4BE24AF624B39D FOREIGN KEY (sender_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE message_perle ADD CONSTRAINT FK_6F4BE24ACD53EDB6 FOREIGN KEY (receiver_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE mon_coffre ADD CONSTRAINT FK_B3718E92275ED078 FOREIGN KEY (profil_id) REFERENCES mon_profil (id)');
        $this->addSql('ALTER TABLE mon_coffre ADD CONSTRAINT FK_B3718E92F1D74413 FOREIGN KEY (abonnement_id) REFERENCES abonnement (id)');
        $this->addSql('ALTER TABLE mon_envie ADD CONSTRAINT FK_370F6406FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE mon_profil ADD CONSTRAINT FK_3A19120A76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CACD53EDB6 FOREIGN KEY (receiver_id) REFERENCES mon_profil (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B112FC61EC7 FOREIGN KEY (conv_id) REFERENCES conversation (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B113951DF75 FOREIGN KEY (uti_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE photo_couverture ADD CONSTRAINT FK_30713308FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE region ADD CONSTRAINT FK_F62F176A6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B398260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3A6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE video_like ADD CONSTRAINT FK_ABF41D6F29C1004E FOREIGN KEY (video_id) REFERENCES video (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video_like ADD CONSTRAINT FK_ABF41D6FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video_utilisateur ADD CONSTRAINT FK_3F9ED21229C1004E FOREIGN KEY (video_id) REFERENCES video (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video_utilisateur ADD CONSTRAINT FK_3F9ED212FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mon_coffre DROP FOREIGN KEY FK_B3718E92F1D74413');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F1137ABCF');
        $this->addSql('ALTER TABLE cadeau_sent DROP FOREIGN KEY FK_52FD2660D9D5ED84');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F2FC61EC7');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B112FC61EC7');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3CCF9E01E');
        $this->addSql('ALTER TABLE mon_coffre DROP FOREIGN KEY FK_B3718E92275ED078');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CACD53EDB6');
        $this->addSql('ALTER TABLE region DROP FOREIGN KEY FK_F62F176A6E44244');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3A6E44244');
        $this->addSql('ALTER TABLE departement DROP FOREIGN KEY FK_C1765B6398260155');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B398260155');
        $this->addSql('ALTER TABLE album DROP FOREIGN KEY FK_39986E43FB88E14F');
        $this->addSql('ALTER TABLE autorised_user DROP FOREIGN KEY FK_FF0E8B12A76ED395');
        $this->addSql('ALTER TABLE autorised_user DROP FOREIGN KEY FK_FF0E8B12CD53EDB6');
        $this->addSql('ALTER TABLE cadeau_sent DROP FOREIGN KEY FK_52FD2660A76ED395');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CB4D5A9E2');
        $this->addSql('ALTER TABLE conversation DROP FOREIGN KEY FK_8A8E26E93951DF75');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FFB88E14F');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F3951DF75');
        $this->addSql('ALTER TABLE message_bourse DROP FOREIGN KEY FK_EAE52113F624B39D');
        $this->addSql('ALTER TABLE message_bourse DROP FOREIGN KEY FK_EAE52113CD53EDB6');
        $this->addSql('ALTER TABLE message_perle DROP FOREIGN KEY FK_6F4BE24AF624B39D');
        $this->addSql('ALTER TABLE message_perle DROP FOREIGN KEY FK_6F4BE24ACD53EDB6');
        $this->addSql('ALTER TABLE mon_envie DROP FOREIGN KEY FK_370F6406FB88E14F');
        $this->addSql('ALTER TABLE mon_profil DROP FOREIGN KEY FK_3A19120A76ED395');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B113951DF75');
        $this->addSql('ALTER TABLE photo_couverture DROP FOREIGN KEY FK_30713308FB88E14F');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CFB88E14F');
        $this->addSql('ALTER TABLE video_like DROP FOREIGN KEY FK_ABF41D6FFB88E14F');
        $this->addSql('ALTER TABLE video_utilisateur DROP FOREIGN KEY FK_3F9ED212FB88E14F');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CC1A7A1A1');
        $this->addSql('ALTER TABLE video_like DROP FOREIGN KEY FK_ABF41D6F29C1004E');
        $this->addSql('ALTER TABLE video_utilisateur DROP FOREIGN KEY FK_3F9ED21229C1004E');
        $this->addSql('DROP TABLE abonnement');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE autorised_user');
        $this->addSql('DROP TABLE cadeau');
        $this->addSql('DROP TABLE cadeau_sent');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE conversation');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE message_bourse');
        $this->addSql('DROP TABLE message_perle');
        $this->addSql('DROP TABLE mon_coffre');
        $this->addSql('DROP TABLE mon_envie');
        $this->addSql('DROP TABLE mon_profil');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE pays');
        $this->addSql('DROP TABLE photo_couverture');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE video');
        $this->addSql('DROP TABLE video_like');
        $this->addSql('DROP TABLE video_utilisateur');
    }
}
