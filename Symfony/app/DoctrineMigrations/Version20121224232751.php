<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20121224232751 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("ALTER TABLE SiteSection ADD picture_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE SiteSection ADD CONSTRAINT FK_EDCF8578EE45BDBF FOREIGN KEY (picture_id) REFERENCES Image (id)");
        $this->addSql("CREATE INDEX IDX_EDCF8578EE45BDBF ON SiteSection (picture_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("ALTER TABLE SiteSection DROP FOREIGN KEY FK_EDCF8578EE45BDBF");
        $this->addSql("DROP INDEX IDX_EDCF8578EE45BDBF ON SiteSection");
        $this->addSql("ALTER TABLE SiteSection DROP picture_id");
    }
}
