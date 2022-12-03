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

-- Carga inicial de datos de prueba:
 INSERT INTO alumnos (nombre)
 VALUES ('Agustin'),
        ('Antonio'),
        ('Enrique');

 INSERT INTO ccee (ce, descripcion)
 VALUES ('aaaa', 'programacion'),
        ('bbbb', 'contabilidad'),
        ('cccc', 'RRHH');

INSERT INTO notas (alumno_id, ccee_id, nota)
VALUES ('1', '1', '6.2'),
       ('1', '2', '7.5'),
       ('1', '3', '5.5');


