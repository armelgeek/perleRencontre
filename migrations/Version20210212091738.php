<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210212091738 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE RoomAccesses DROP FOREIGN KEY RoomAccesses_ibfk_1');
        $this->addSql('ALTER TABLE RoomAccesses DROP FOREIGN KEY RoomAccesses_ibfk_2');
        $this->addSql('ALTER TABLE RoomAccesses DROP FOREIGN KEY RoomAccesses_ibfk_3');
        $this->addSql('CREATE TABLE conversation (id INT AUTO_INCREMENT NOT NULL, last_message_id_id INT DEFAULT NULL, uti_id_id INT NOT NULL, name VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8A8E26E9ECED022B (last_message_id_id), INDEX IDX_8A8E26E92EB7D700 (uti_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participant (id INT AUTO_INCREMENT NOT NULL, uti_id_id INT NOT NULL, conv_id_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_D79F6B112EB7D700 (uti_id_id), INDEX IDX_D79F6B1154E71D80 (conv_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9ECED022B FOREIGN KEY (last_message_id_id) REFERENCES message (id)');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E92EB7D700 FOREIGN KEY (uti_id_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B112EB7D700 FOREIGN KEY (uti_id_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B1154E71D80 FOREIGN KEY (conv_id_id) REFERENCES conversation (id)');
        $this->addSql('DROP TABLE Messages');
        $this->addSql('DROP TABLE RoomAccesses');
        $this->addSql('DROP TABLE Rooms');
        $this->addSql('DROP TABLE Users');
        $this->addSql('ALTER TABLE utilisateur ADD is_online TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B1154E71D80');
        $this->addSql('CREATE TABLE Messages (id INT AUTO_INCREMENT NOT NULL, messageid INT DEFAULT NULL, userid INT DEFAULT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE RoomAccesses (roomid INT NOT NULL, userid INT NOT NULL, createdid INT NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, INDEX createdid (createdid), UNIQUE INDEX RoomAccesses_userid_roomid_unique (roomid, userid), INDEX userid (userid), INDEX IDX_9B192ED131E0277C (roomid), PRIMARY KEY(roomid, userid)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE Rooms (id INT AUTO_INCREMENT NOT NULL, uuid VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, createdid INT NOT NULL, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE Users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, name VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, createdAt DATETIME DEFAULT NULL, updatedAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE RoomAccesses ADD CONSTRAINT RoomAccesses_ibfk_1 FOREIGN KEY (roomid) REFERENCES Rooms (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE RoomAccesses ADD CONSTRAINT RoomAccesses_ibfk_2 FOREIGN KEY (userid) REFERENCES Users (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE RoomAccesses ADD CONSTRAINT RoomAccesses_ibfk_3 FOREIGN KEY (createdid) REFERENCES Users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE conversation');
        $this->addSql('DROP TABLE participant');
        $this->addSql('ALTER TABLE utilisateur DROP is_online');
    }
}
