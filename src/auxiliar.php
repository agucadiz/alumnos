<?php

function conectar()
{
    return new \PDO('pgsql:host=localhost,dbname=alumnos', 'alumnos', 'alumnos');
}

function hh($x)
{
    return htmlspecialchars($x ?? '', ENT_QUOTES | ENT_SUBSTITUTE);
}