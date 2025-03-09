<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250308233143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE lista (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(100) NOT NULL, tipo VARCHAR(10) DEFAULT \'custom\' NOT NULL, usuario_id INT DEFAULT NULL, INDEX IDX_FB9FEEEDDB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE lista_pelicula (lista_id INT NOT NULL, pelicula_id INT NOT NULL, INDEX IDX_668A8B156736D68F (lista_id), INDEX IDX_668A8B1570713909 (pelicula_id), PRIMARY KEY(lista_id, pelicula_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE pelicula (id INT AUTO_INCREMENT NOT NULL, titulo VARCHAR(255) NOT NULL, anio INT NOT NULL, sinopsis LONGTEXT DEFAULT NULL, imagen VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, UNIQUE INDEX UNIQ_73BC709517713E5A (titulo), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE review (vista TINYINT(1) DEFAULT 0 NOT NULL, nota INT DEFAULT NULL, comentario LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, modified_at DATETIME DEFAULT NULL, usuario_id INT NOT NULL, pelicula_id INT NOT NULL, INDEX IDX_794381C6DB38439E (usuario_id), INDEX IDX_794381C670713909 (pelicula_id), PRIMARY KEY(usuario_id, pelicula_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE lista ADD CONSTRAINT FK_FB9FEEEDDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lista_pelicula ADD CONSTRAINT FK_668A8B156736D68F FOREIGN KEY (lista_id) REFERENCES lista (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lista_pelicula ADD CONSTRAINT FK_668A8B1570713909 FOREIGN KEY (pelicula_id) REFERENCES pelicula (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C670713909 FOREIGN KEY (pelicula_id) REFERENCES pelicula (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lista DROP FOREIGN KEY FK_FB9FEEEDDB38439E');
        $this->addSql('ALTER TABLE lista_pelicula DROP FOREIGN KEY FK_668A8B156736D68F');
        $this->addSql('ALTER TABLE lista_pelicula DROP FOREIGN KEY FK_668A8B1570713909');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6DB38439E');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C670713909');
        $this->addSql('DROP TABLE lista');
        $this->addSql('DROP TABLE lista_pelicula');
        $this->addSql('DROP TABLE pelicula');
        $this->addSql('DROP TABLE review');
    }
}
