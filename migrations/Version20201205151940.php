<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201205151940 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur CHANGE je_cherche je_cherche JSON DEFAULT NULL, CHANGE degaine degaine JSON DEFAULT NULL, CHANGE sexualite sexualite JSON DEFAULT NULL, CHANGE style_de_cheveux style_de_cheveux JSON DEFAULT NULL, CHANGE silouhette silouhette JSON DEFAULT NULL, CHANGE j_ai_un_faible_pour j_ai_un_faible_pour JSON DEFAULT NULL, CHANGE origines origines JSON DEFAULT NULL, CHANGE j_aime_porter_ou_pas j_aime_porter_ou_pas JSON DEFAULT NULL, CHANGE je_frissone_pour je_frissone_pour JSON DEFAULT NULL, CHANGE proffessions proffessions JSON DEFAULT NULL, CHANGE sports sports JSON DEFAULT NULL, CHANGE hobbies hobbies JSON DEFAULT NULL, CHANGE alcool alcool JSON DEFAULT NULL, CHANGE tabac tabac JSON DEFAULT NULL, CHANGE alimentation alimentation JSON DEFAULT NULL, CHANGE j_aime_manger j_aime_manger JSON DEFAULT NULL, CHANGE scolarite scolarite JSON DEFAULT NULL, CHANGE langues langues JSON DEFAULT NULL, CHANGE signe_astrologique signe_astrologique JSON DEFAULT NULL, CHANGE avec_ou_sans_enfant avec_ou_sans_enfant TINYINT(1) DEFAULT NULL, CHANGE gout_musicaux gout_musicaux JSON DEFAULT NULL, CHANGE religions religions JSON DEFAULT NULL, CHANGE personalite personalite JSON DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE ville ville VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur CHANGE je_cherche je_cherche JSON NOT NULL, CHANGE degaine degaine JSON NOT NULL, CHANGE sexualite sexualite JSON NOT NULL, CHANGE style_de_cheveux style_de_cheveux JSON NOT NULL, CHANGE silouhette silouhette JSON NOT NULL, CHANGE j_ai_un_faible_pour j_ai_un_faible_pour JSON NOT NULL, CHANGE origines origines JSON NOT NULL, CHANGE j_aime_porter_ou_pas j_aime_porter_ou_pas JSON NOT NULL, CHANGE je_frissone_pour je_frissone_pour JSON NOT NULL, CHANGE proffessions proffessions JSON NOT NULL, CHANGE sports sports JSON NOT NULL, CHANGE hobbies hobbies JSON NOT NULL, CHANGE alcool alcool JSON NOT NULL, CHANGE tabac tabac JSON NOT NULL, CHANGE alimentation alimentation JSON NOT NULL, CHANGE j_aime_manger j_aime_manger JSON NOT NULL, CHANGE scolarite scolarite JSON NOT NULL, CHANGE langues langues JSON NOT NULL, CHANGE signe_astrologique signe_astrologique JSON NOT NULL, CHANGE avec_ou_sans_enfant avec_ou_sans_enfant TINYINT(1) NOT NULL, CHANGE gout_musicaux gout_musicaux JSON NOT NULL, CHANGE religions religions JSON NOT NULL, CHANGE personalite personalite JSON NOT NULL, CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE ville ville VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
