<?php 

require '../vendor/autoload.php';
use App\Tablas\Alumno;

$id = obtener_post('id');

if (!isset($id)) {
    return volver();
}

$pdo = conectar();

Alumno::borrar($id);

volver();