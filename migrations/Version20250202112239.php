<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250202112239 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category_news_channel (category_id INT NOT NULL, news_channel_id INT NOT NULL, PRIMARY KEY(category_id, news_channel_id))');
        $this->addSql('CREATE INDEX IDX_2FCAB13312469DE2 ON category_news_channel (category_id)');
        $this->addSql('CREATE INDEX IDX_2FCAB1339E8A76D3 ON category_news_channel (news_channel_id)');
        $this->addSql('ALTER TABLE category_news_channel ADD CONSTRAINT FK_2FCAB13312469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_news_channel ADD CONSTRAINT FK_2FCAB1339E8A76D3 FOREIGN KEY (news_channel_id) REFERENCES news_channel (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category DROP CONSTRAINT fk_64c19c19e8a76d3');
        $this->addSql('DROP INDEX idx_64c19c19e8a76d3');
        $this->addSql('ALTER TABLE category DROP news_channel_id');
        $this->addSql('ALTER TABLE news ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE news ADD parsed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN news.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN news.parsed_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE category_news_channel DROP CONSTRAINT FK_2FCAB13312469DE2');
        $this->addSql('ALTER TABLE category_news_channel DROP CONSTRAINT FK_2FCAB1339E8A76D3');
        $this->addSql('DROP TABLE category_news_channel');
        $this->addSql('ALTER TABLE category ADD news_channel_id INT NOT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT fk_64c19c19e8a76d3 FOREIGN KEY (news_channel_id) REFERENCES news_channel (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_64c19c19e8a76d3 ON category (news_channel_id)');
        $this->addSql('ALTER TABLE news DROP created_at');
        $this->addSql('ALTER TABLE news DROP parsed_at');
    }
}
