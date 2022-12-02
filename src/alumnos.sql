DROP TABLE IF EXISTS alumnos CASCADE;

CREATE TABLE alumnos (
    id          bigserial     PRIMARY KEY,
    nombre      varchar(255)  NOT NULL
);

DROP TABLE IF EXISTS ccee CASCADE;

CREATE TABLE ccee (
    id          bigserial     PRIMARY KEY,
    ce          varchar(4)    NOT NULL UNIQUE,
    descripcion varchar(255)  NOT NULL
);

DROP TABLE IF EXISTS notas CASCADE;

CREATE TABLE notas (
    id          bigserial     NOT NULL UNIQUE,
    alumno_id   bigint        NOT NULL REFERENCES alumnos (id),
    ccee_id     bigint        NOT NULL REFERENCES ccee (id),
    nota        numeric(4, 2) NOT NULL,
    PRIMARY KEY (alumno_id, ccee_id)
);


