<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200618201603 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE migration_versions');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3BF396750');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3C53D4415');
        $this->addSql('DROP INDEX IDX_97A0ADA3C53D4415 ON ticket');
        $this->addSql('ALTER TABLE ticket ADD client_id INT NOT NULL, CHANGE id_personel personel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3A8C3AF89 FOREIGN KEY (personel_id) REFERENCES personel (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA319EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3A8C3AF89 ON ticket (personel_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA319EB6921 ON ticket (client_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE migration_versions (version VARCHAR(14) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, executed_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(version)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3A8C3AF89');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA319EB6921');
        $this->addSql('DROP INDEX IDX_97A0ADA3A8C3AF89 ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA319EB6921 ON ticket');
        $this->addSql('ALTER TABLE ticket DROP client_id, CHANGE personel_id id_personel INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3BF396750 FOREIGN KEY (id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3C53D4415 FOREIGN KEY (id_personel) REFERENCES personel (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3C53D4415 ON ticket (id_personel)');
    }
}
