<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200207212556 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_jobapplication');
        $this->addSql('ALTER TABLE user ADD lastname VARCHAR(255) NOT NULL, ADD gender VARCHAR(255) NOT NULL, ADD birthdate DATE NOT NULL, ADD job_love VARCHAR(255) NOT NULL, ADD plain_password VARCHAR(255) NOT NULL, CHANGE roles roles JSON NOT NULL, CHANGE password firstname VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_jobapplication (user_id INT NOT NULL, jobapplication_id INT NOT NULL, INDEX IDX_C6E262FD3A8D142F (jobapplication_id), INDEX IDX_C6E262FDA76ED395 (user_id), PRIMARY KEY(user_id, jobapplication_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_jobapplication ADD CONSTRAINT FK_C6E262FD3A8D142F FOREIGN KEY (jobapplication_id) REFERENCES job_application (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_jobapplication ADD CONSTRAINT FK_C6E262FDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP firstname, DROP lastname, DROP gender, DROP birthdate, DROP job_love, DROP plain_password, CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
