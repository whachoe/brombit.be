<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170629182920 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE fos_user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE balance (date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, btc VARCHAR(255) NOT NULL, eth VARCHAR(255) NOT NULL, ltc VARCHAR(255) NOT NULL, zec VARCHAR(255) NOT NULL, total_euro VARCHAR(255) NOT NULL, PRIMARY KEY(date))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ACF41FFEAA9E377A ON balance (date)');
        $this->addSql('CREATE TABLE transaction_history (date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, from_currency VARCHAR(255) NOT NULL, to_currency VARCHAR(255) NOT NULL, from_amount VARCHAR(255) NOT NULL, to_amount VARCHAR(255) NOT NULL, PRIMARY KEY(date))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_51104CA9AA9E377A ON transaction_history (date)');
        $this->addSql('CREATE TABLE fos_user (id INT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled BOOLEAN NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, roles TEXT NOT NULL, eth_address TEXT NOT NULL, initial_funds INT NOT NULL, percentage DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A647992FC23A8 ON fos_user (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A6479A0D96FBF ON fos_user (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_957A6479C05FB297 ON fos_user (confirmation_token)');
        $this->addSql('CREATE INDEX IDX_957A6479B03A8386 ON fos_user (created_by_id)');
        $this->addSql('CREATE INDEX IDX_957A6479896DBBDE ON fos_user (updated_by_id)');
        $this->addSql('COMMENT ON COLUMN fos_user.roles IS \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE fos_user ADD CONSTRAINT FK_957A6479B03A8386 FOREIGN KEY (created_by_id) REFERENCES fos_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE fos_user ADD CONSTRAINT FK_957A6479896DBBDE FOREIGN KEY (updated_by_id) REFERENCES fos_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE fos_user DROP CONSTRAINT FK_957A6479B03A8386');
        $this->addSql('ALTER TABLE fos_user DROP CONSTRAINT FK_957A6479896DBBDE');
        $this->addSql('DROP SEQUENCE fos_user_id_seq CASCADE');
        $this->addSql('DROP TABLE balance');
        $this->addSql('DROP TABLE transaction_history');
        $this->addSql('DROP TABLE fos_user');
    }
}
