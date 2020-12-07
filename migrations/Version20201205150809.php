<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201205150809 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE album (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, privat TINYINT(1) NOT NULL, INDEX IDX_39986E43FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, commented_id INT NOT NULL, commenter_id INT NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_9474526CC1A7A1A1 (commented_id), INDEX IDX_9474526CB4D5A9E2 (commenter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departement (id INT AUTO_INCREMENT NOT NULL, region_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_C1765B6398260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, album_id INT NOT NULL, utilisateur_id INT DEFAULT NULL, imagepath VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_C53D045F1137ABCF (album_id), INDEX IDX_C53D045FFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mon_envie (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, envie_du_jour VARCHAR(255) NOT NULL, date_du_jour DATETIME NOT NULL, INDEX IDX_370F6406FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pays (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photo_couverture (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, image_name VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_30713308FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, pays_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_F62F176A6E44244 (pays_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT DEFAULT NULL, videopath VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, title VARCHAR(255) NOT NULL, privat TINYINT(1) NOT NULL, INDEX IDX_7CC7DA2CFB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video_like (video_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_ABF41D6F29C1004E (video_id), INDEX IDX_ABF41D6FFB88E14F (utilisateur_id), PRIMARY KEY(video_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video_utilisateur (video_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_3F9ED21229C1004E (video_id), INDEX IDX_3F9ED212FB88E14F (utilisateur_id), PRIMARY KEY(video_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E43FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CC1A7A1A1 FOREIGN KEY (commented_id) REFERENCES video (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CB4D5A9E2 FOREIGN KEY (commenter_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE departement ADD CONSTRAINT FK_C1765B6398260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F1137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE mon_envie ADD CONSTRAINT FK_370F6406FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE photo_couverture ADD CONSTRAINT FK_30713308FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE region ADD CONSTRAINT FK_F62F176A6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE video_like ADD CONSTRAINT FK_ABF41D6F29C1004E FOREIGN KEY (video_id) REFERENCES video (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video_like ADD CONSTRAINT FK_ABF41D6FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video_utilisateur ADD CONSTRAINT FK_3F9ED21229C1004E FOREIGN KEY (video_id) REFERENCES video (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE video_utilisateur ADD CONSTRAINT FK_3F9ED212FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur ADD departement_id INT DEFAULT NULL, ADD region_id INT DEFAULT NULL, ADD pays_id INT DEFAULT NULL, ADD genre TINYINT(1) NOT NULL, ADD je_cherche JSON NOT NULL, ADD date_naissance DATETIME NOT NULL, ADD description VARCHAR(255) DEFAULT NULL, ADD age INT DEFAULT NULL, ADD couleur_de_cheveux JSON NOT NULL, ADD degaine JSON NOT NULL, ADD sexualite JSON NOT NULL, ADD taille INT NOT NULL, ADD style_de_cheveux JSON NOT NULL, ADD silouhette JSON NOT NULL, ADD j_ai_un_faible_pour JSON NOT NULL, ADD poids INT NOT NULL, ADD couleur_des_yeux VARCHAR(255) DEFAULT NULL, ADD origines JSON NOT NULL, ADD j_aime_porter_ou_pas JSON NOT NULL, ADD je_frissone_pour JSON NOT NULL, ADD passions_au_lit VARCHAR(255) DEFAULT NULL, ADD proffessions JSON NOT NULL, ADD sports JSON NOT NULL, ADD hobbies JSON NOT NULL, ADD alcool JSON NOT NULL, ADD tabac JSON NOT NULL, ADD alimentation JSON NOT NULL, ADD j_aime_manger JSON NOT NULL, ADD scolarite JSON NOT NULL, ADD langues JSON NOT NULL, ADD signe_astrologique JSON NOT NULL, ADD avec_ou_sans_enfant TINYINT(1) NOT NULL, ADD gout_musicaux JSON NOT NULL, ADD religions JSON NOT NULL, ADD personalite JSON NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD ville VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B398260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3A6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3CCF9E01E ON utilisateur (departement_id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B398260155 ON utilisateur (region_id)');
        $this->addSql('CREATE INDEX IDX_1D1C63B3A6E44244 ON utilisateur (pays_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F1137ABCF');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3CCF9E01E');
        $this->addSql('ALTER TABLE region DROP FOREIGN KEY FK_F62F176A6E44244');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3A6E44244');
        $this->addSql('ALTER TABLE departement DROP FOREIGN KEY FK_C1765B6398260155');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B398260155');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CC1A7A1A1');
        $this->addSql('ALTER TABLE video_like DROP FOREIGN KEY FK_ABF41D6F29C1004E');
        $this->addSql('ALTER TABLE video_utilisateur DROP FOREIGN KEY FK_3F9ED21229C1004E');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE departement');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE mon_envie');
        $this->addSql('DROP TABLE pays');
        $this->addSql('DROP TABLE photo_couverture');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE video');
        $this->addSql('DROP TABLE video_like');
        $this->addSql('DROP TABLE video_utilisateur');
        $this->addSql('DROP INDEX IDX_1D1C63B3CCF9E01E ON utilisateur');
        $this->addSql('DROP INDEX IDX_1D1C63B398260155 ON utilisateur');
        $this->addSql('DROP INDEX IDX_1D1C63B3A6E44244 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur DROP departement_id, DROP region_id, DROP pays_id, DROP genre, DROP je_cherche, DROP date_naissance, DROP description, DROP age, DROP couleur_de_cheveux, DROP degaine, DROP sexualite, DROP taille, DROP style_de_cheveux, DROP silouhette, DROP j_ai_un_faible_pour, DROP poids, DROP couleur_des_yeux, DROP origines, DROP j_aime_porter_ou_pas, DROP je_frissone_pour, DROP passions_au_lit, DROP proffessions, DROP sports, DROP hobbies, DROP alcool, DROP tabac, DROP alimentation, DROP j_aime_manger, DROP scolarite, DROP langues, DROP signe_astrologique, DROP avec_ou_sans_enfant, DROP gout_musicaux, DROP religions, DROP personalite, DROP email, DROP ville');
    }
}
