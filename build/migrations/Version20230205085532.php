<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230205085532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE music_library__album_artist (
          album_id CHAR(26) NOT NULL COMMENT \'(DC2Type:album_id)\',
          artist_id CHAR(26) NOT NULL COMMENT \'(DC2Type:artist_id)\',
          INDEX IDX_BDBEDDB31137ABCF (album_id),
          INDEX IDX_BDBEDDB3B7970CF8 (artist_id),
          PRIMARY KEY(album_id, artist_id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE music_library__artist (
          id CHAR(26) NOT NULL COMMENT \'(DC2Type:artist_id)\',
          external_artist_id VARCHAR(255) NOT NULL COMMENT \'(DC2Type:external_artist_id)\',
          name VARCHAR(255) NOT NULL,
          PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_0900_ai_ci` ENGINE = InnoDB');

        $this->addSql('ALTER TABLE
          music_library__album_artist
        ADD
          CONSTRAINT FK_BDBEDDB31137ABCF FOREIGN KEY (album_id) REFERENCES music_library__album (id) ON DELETE CASCADE');

        $this->addSql('ALTER TABLE
          music_library__album_artist
        ADD
          CONSTRAINT FK_BDBEDDB3B7970CF8 FOREIGN KEY (artist_id) REFERENCES music_library__artist (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE music_library__album_artist DROP FOREIGN KEY FK_BDBEDDB31137ABCF');
        $this->addSql('ALTER TABLE music_library__album_artist DROP FOREIGN KEY FK_BDBEDDB3B7970CF8');
        $this->addSql('DROP TABLE music_library__album_artist');
        $this->addSql('DROP TABLE music_library__artist');
    }
}
