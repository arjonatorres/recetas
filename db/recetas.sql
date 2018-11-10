------------------------------
-- Archivo de base de datos --
------------------------------

DROP TABLE IF EXISTS usuarios CASCADE;
CREATE TABLE usuarios
(
    id       BIGSERIAL     PRIMARY KEY,
    usuario  VARCHAR(255),
    password VARCHAR(255)  NOT NULL,
    token    VARCHAR(255)
);

DROP TABLE IF EXISTS categorias CASCADE;
CREATE TABLE categorias
(
    id       BIGSERIAL     PRIMARY KEY,
    nombre  VARCHAR(255)
);

DROP TABLE IF EXISTS recetas CASCADE;
CREATE TABLE recetas
(
    id           bigserial      PRIMARY KEY
  , titulo       varchar(255)   NOT NULL
  , historia     varchar(10000)
  , ingredientes varchar(10000) NOT NULL
  , comensales   numeric(2)
  , pie          varchar(10000)
  , categoria_id bigint         NOT NULL REFERENCES categorias (id)
                                ON DELETE NO ACTION ON UPDATE CASCADE
  , usuario_id   bigint         NOT NULL REFERENCES usuarios (id)
                                ON DELETE NO ACTION ON UPDATE CASCADE
  , created_at   timestamp(0)   NOT NULL DEFAULT localtimestamp
);

CREATE INDEX idx_recetas_titulo ON recetas (titulo);

DROP TABLE IF EXISTS pasos CASCADE;
CREATE TABLE pasos
(
    id        bigserial  PRIMARY KEY
  , texto     numeric(6) NOT NULL UNIQUE
  , receta_id bigint     NOT NULL REFERENCES recetas (id)
                         ON DELETE NO ACTION ON UPDATE CASCADE
);


---------------------
-- Datos iniciales --
---------------------

INSERT INTO categorias (nombre)
     VALUES ('Aperitivos y tapas'),
            ('Arroces y cereales'),
            ('Aves y caza'),
            ('Carne'),
            ('Cócteles y bebidas'),
            ('Ensaladas'),
            ('Guisos y Potajes'),
            ('Huevos y lácteos'),
            ('Mariscos'),
            ('Pan y bollería'),
            ('Pasta'),
            ('Pescado'),
            ('Postres'),
            ('Salsas'),
            ('Sopas y cremas'),
            ('Verduras');
