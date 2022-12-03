<?php

function conectar()
{
    return new \PDO('pgsql:host=localhost,dbname=alumnos', 'alumnos', 'alumnos');
}

