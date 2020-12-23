<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201223133834 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_monobank_token DROP FOREIGN KEY FK_1CC28C579D86650F');
        $this->addSql('DROP INDEX UNIQ_1CC28C579D86650F ON user_monobank_token');
        $this->addSql('ALTER TABLE user_monobank_token CHANGE user_id_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_monobank_token ADD CONSTRAINT FK_1CC28C57A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1CC28C57A76ED395 ON user_monobank_token (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_monobank_token DROP FOREIGN KEY FK_1CC28C57A76ED395');
        $this->addSql('DROP INDEX UNIQ_1CC28C57A76ED395 ON user_monobank_token');
        $this->addSql('ALTER TABLE user_monobank_token CHANGE user_id user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_monobank_token ADD CONSTRAINT FK_1CC28C579D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1CC28C579D86650F ON user_monobank_token (user_id_id)');
    }
}
