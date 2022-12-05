<?php

session_start();

require '../vendor/autoload.php';

use App\Tablas\Alumno;

$id = obtener_post('id');

if (!isset($id)) {
    return volver();
}

$pdo = conectar();

Alumno::borrar($id);

$_SESSION['exito'] = 'El alumno se ha borrado correctamente.';

volver();
