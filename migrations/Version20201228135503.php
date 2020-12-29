<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201228135503 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, card_id INT NOT NULL, category_id INT NOT NULL, code VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, custom_description VARCHAR(255) DEFAULT NULL, mcc INT DEFAULT NULL, amount DOUBLE PRECISION NOT NULL, commission DOUBLE PRECISION DEFAULT NULL, cashback DOUBLE PRECISION DEFAULT NULL, create_at INT NOT NULL, INDEX IDX_723705D14ACC9A20 (card_id), INDEX IDX_723705D112469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_monobank_token (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, token VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1CC28C57A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_privat_token (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, privat_id INT NOT NULL, pass VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B7FDFD57A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D14ACC9A20 FOREIGN KEY (card_id) REFERENCES card (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D112469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE user_monobank_token ADD CONSTRAINT FK_1CC28C57A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_privat_token ADD CONSTRAINT FK_B7FDFD57A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D39D86650F');
        $this->addSql('DROP INDEX IDX_161498D39D86650F ON card');
        $this->addSql('ALTER TABLE card ADD number_card VARCHAR(30) DEFAULT NULL, ADD key_card VARCHAR(255) DEFAULT NULL, DROP card_id, DROP card_key, DROP is_published, CHANGE bank bank VARCHAR(50) NOT NULL, CHANGE name name VARCHAR(100) NOT NULL, CHANGE currency currency VARCHAR(4) NOT NULL, CHANGE user_id_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_161498D3A76ED395 ON card (user_id)');
        $this->addSql('ALTER TABLE category CHANGE keywords keywords VARCHAR(2000) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE transaction');
        $this->addSql('DROP TABLE user_monobank_token');
        $this->addSql('DROP TABLE user_privat_token');
        $this->addSql('ALTER TABLE card DROP FOREIGN KEY FK_161498D3A76ED395');
        $this->addSql('DROP INDEX IDX_161498D3A76ED395 ON card');
        $this->addSql('ALTER TABLE card ADD card_key VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD is_published TINYINT(1) NOT NULL, DROP number_card, CHANGE bank bank VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE name name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE currency currency VARCHAR(5) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE user_id user_id_id INT NOT NULL, CHANGE key_card card_id VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE card ADD CONSTRAINT FK_161498D39D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_161498D39D86650F ON card (user_id_id)');
        $this->addSql('ALTER TABLE category CHANGE keywords keywords VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
