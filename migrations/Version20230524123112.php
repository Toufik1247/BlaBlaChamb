<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230524123112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ride_rule (ride_id INT NOT NULL, rule_id INT NOT NULL, INDEX IDX_DE799B8302A8A70 (ride_id), INDEX IDX_DE799B8744E0351 (rule_id), PRIMARY KEY(ride_id, rule_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rule (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_46D8ACCCF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ride_rule ADD CONSTRAINT FK_DE799B8302A8A70 FOREIGN KEY (ride_id) REFERENCES ride (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ride_rule ADD CONSTRAINT FK_DE799B8744E0351 FOREIGN KEY (rule_id) REFERENCES rule (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rule ADD CONSTRAINT FK_46D8ACCCF675F31B FOREIGN KEY (author_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE ride ADD driver_id INT NOT NULL');
        $this->addSql('ALTER TABLE ride ADD CONSTRAINT FK_9B3D7CD0C3423909 FOREIGN KEY (driver_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_9B3D7CD0C3423909 ON ride (driver_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ride_rule DROP FOREIGN KEY FK_DE799B8302A8A70');
        $this->addSql('ALTER TABLE ride_rule DROP FOREIGN KEY FK_DE799B8744E0351');
        $this->addSql('ALTER TABLE rule DROP FOREIGN KEY FK_46D8ACCCF675F31B');
        $this->addSql('DROP TABLE ride_rule');
        $this->addSql('DROP TABLE rule');
        $this->addSql('ALTER TABLE ride DROP FOREIGN KEY FK_9B3D7CD0C3423909');
        $this->addSql('DROP INDEX IDX_9B3D7CD0C3423909 ON ride');
        $this->addSql('ALTER TABLE ride DROP driver_id');
    }
}
