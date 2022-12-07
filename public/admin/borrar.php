<?php

session_start();

require '../../vendor/autoload.php';

use App\Tablas\Alumno;

$id = obtener_post('id');

if (!isset($id)) {
    return volver_admin();
}

// TODO. Comprobar si el alumno tiene notas.

$pdo = conectar();
Alumno::borrar($id);
$_SESSION['exito'] = 'El alumno se ha borrado correctamente.';
volver_admin();
