<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200205214856 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE job_application_user (job_application_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A7995E47AC7A5A08 (job_application_id), INDEX IDX_A7995E47A76ED395 (user_id), PRIMARY KEY(job_application_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE job_application_user ADD CONSTRAINT FK_A7995E47AC7A5A08 FOREIGN KEY (job_application_id) REFERENCES job_application (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_application_user ADD CONSTRAINT FK_A7995E47A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE job_application ADD recruiter_id INT NOT NULL');
        $this->addSql('ALTER TABLE job_application ADD CONSTRAINT FK_C737C688156BE243 FOREIGN KEY (recruiter_id) REFERENCES recruiter (id)');
        $this->addSql('CREATE INDEX IDX_C737C688156BE243 ON job_application (recruiter_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE job_application_user');
        $this->addSql('ALTER TABLE job_application DROP FOREIGN KEY FK_C737C688156BE243');
        $this->addSql('DROP INDEX IDX_C737C688156BE243 ON job_application');
        $this->addSql('ALTER TABLE job_application DROP recruiter_id');
    }
}
