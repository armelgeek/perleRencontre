<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210219074543 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chat (id INT AUTO_INCREMENT NOT NULL, uti1_id INT NOT NULL, uti2_id INT NOT NULL, conv_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_659DF2AAF63AF9FF (uti1_id), INDEX IDX_659DF2AAE48F5611 (uti2_id), UNIQUE INDEX UNIQ_659DF2AA2FC61EC7 (conv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AAF63AF9FF FOREIGN KEY (uti1_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AAE48F5611 FOREIGN KEY (uti2_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AA2FC61EC7 FOREIGN KEY (conv_id) REFERENCES conversation (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE chat');
    }
}
