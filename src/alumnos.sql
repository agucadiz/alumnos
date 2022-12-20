DROP TABLE IF EXISTS alumnos CASCADE;

CREATE TABLE alumnos (
    id          bigserial     PRIMARY KEY,
    nombre      varchar(255)  NOT NULL,
    fecha_nac   TIMESTAMP     NOT NULL
);

DROP TABLE IF EXISTS ccee CASCADE;

CREATE TABLE ccee (
    id          bigserial     PRIMARY KEY,
    ce          varchar(4)    NOT NULL UNIQUE,
    descripcion varchar(255)  NOT NULL
);

DROP TABLE IF EXISTS notas CASCADE;

CREATE TABLE notas (
    id          bigserial     PRIMARY KEY,
    alumno_id   bigint        NOT NULL REFERENCES alumnos (id),
    ccee_id     bigint        NOT NULL REFERENCES ccee (id),
    nota        numeric(4, 2) NOT NULL,
    UNIQUE (alumno_id, ccee_id)
);

DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios (
    id       bigserial    PRIMARY KEY,
    usuario  varchar(255) NOT NULL UNIQUE,
    password varchar(255) NOT NULL
);

-- Carga inicial de datos de prueba:
 INSERT INTO alumnos (nombre, fecha_nac)
 VALUES ('Agustin', '1982-12-01'),
        ('Antonio', '1995-11-16'),
        ('Enrique', '1999-07-30');

 INSERT INTO ccee (ce, descripcion)
 VALUES ('aaaa', 'programacion'),
        ('bbbb', 'contabilidad'),
        ('cccc', 'RRHH');

INSERT INTO notas (alumno_id, ccee_id, nota)
VALUES ('1', '1', '6.2'),
       ('1', '2', '7.5'),
       ('1', '3', '5.5'),
       ('2', '1', '4.5'),
       ('2', '2', '7.5'),
       ('2', '3', '8.2');

INSERT INTO usuarios (usuario, password)
    VALUES ('admin', crypt('admin', gen_salt('bf', 10))),
           ('pepe', crypt('pepe', gen_salt('bf', 10)));


