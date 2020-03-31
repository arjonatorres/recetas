------------------------------
-- Archivo de base de datos --
------------------------------

DROP TABLE IF EXISTS usuarios CASCADE;
CREATE TABLE usuarios
(
    id         BIGINT       NOT NULL AUTO_INCREMENT PRIMARY KEY
  , usuario    VARCHAR(255) NOT NULL UNIQUE
  , password   VARCHAR(255) NOT NULL
  , email      VARCHAR(255) NOT NULL
  , auth_key   VARCHAR(255)
  , token_val  VARCHAR(255) UNIQUE
  , created_at TIMESTAMP(0) NOT NULL DEFAULT LOCALTIMESTAMP
  , updated_at TIMESTAMP(0)
);

DROP TABLE IF EXISTS categorias CASCADE;
CREATE TABLE categorias
(
    id      BIGINT       NOT NULL AUTO_INCREMENT PRIMARY KEY
  , nombre  VARCHAR(255)
);

DROP TABLE IF EXISTS dificultades CASCADE;
CREATE TABLE dificultades
(
    id      BIGINT       NOT NULL AUTO_INCREMENT PRIMARY KEY
  , nombre  VARCHAR(255)
);

DROP TABLE IF EXISTS etiquetas CASCADE;
CREATE TABLE etiquetas
(
    id      BIGINT       NOT NULL AUTO_INCREMENT PRIMARY KEY
  , nombre  VARCHAR(255) UNIQUE
);

DROP TABLE IF EXISTS recetas CASCADE;
CREATE TABLE recetas
(
    id            BIGINT         NOT NULL AUTO_INCREMENT PRIMARY KEY
  , titulo        VARCHAR(255)   NOT NULL
  , historia      VARCHAR(4000)
  , ingredientes  VARCHAR(4000) NOT NULL
  , comensales    NUMERIC(2)
  , comentarios   VARCHAR(4000)
  , tiempo        VARCHAR(10)
  , categoria_id  BIGINT         NOT NULL REFERENCES categorias (id)
                                 ON DELETE NO ACTION ON UPDATE CASCADE
  , dificultad_id BIGINT         NOT NULL REFERENCES dificultades (id)
                                 ON DELETE NO ACTION ON UPDATE CASCADE
  , usuario_id    BIGINT         NOT NULL REFERENCES usuarios (id)
                                 ON DELETE NO ACTION ON UPDATE CASCADE
  , created_at    TIMESTAMP(0)   NOT NULL DEFAULT localtimestamp
  , updated_at    TIMESTAMP(0)
);

CREATE INDEX idx_recetas_titulo ON recetas (titulo);

DROP TABLE IF EXISTS recetas_etiquetas CASCADE;
CREATE TABLE recetas_etiquetas
(
    receta_id   BIGINT       NOT NULL REFERENCES recetas (id)
                             ON DELETE NO ACTION ON UPDATE CASCADE
  , etiqueta_id BIGINT       NOT NULL REFERENCES etiquetas (id)
                             ON DELETE NO ACTION ON UPDATE CASCADE
  , PRIMARY KEY (receta_id, etiqueta_id)
);

DROP TABLE IF EXISTS pasos CASCADE;
CREATE TABLE pasos
(
    id        BIGINT         NOT NULL AUTO_INCREMENT PRIMARY KEY
  , texto     VARCHAR(10000) NOT NULL
  , receta_id BIGINT         NOT NULL REFERENCES recetas (id)
                             ON DELETE NO ACTION ON UPDATE CASCADE
);


---------------------
-- Datos iniciales --
---------------------

INSERT INTO categorias (nombre)
     VALUES ('Aperitivos y tapas'),
            ('Arroces y cereales'),
            ('Aves y caza'),
            ('Bebidas, cócteles e infusiones'),
            ('Carne'),
            ('Cócteles y bebidas'),
            ('Ensaladas'),
            ('Guisos y Potajes'),
            ('Huevos y lácteos'),
            ('Legumbres'),
            ('Mariscos'),
            ('Pan y bollería'),
            ('Pasta'),
            ('Pescado'),
            ('Postres y dulces'),
            ('Salsas'),
            ('Sopas y cremas'),
            ('Verduras');

INSERT INTO dificultades (nombre)
     VALUES ('Fácil'),
            ('Media'),
            ('Difícil');