<?php

session_start();

require '../../vendor/autoload.php';

use App\Tablas\Alumno;

$id = obtener_post('id');

if (!isset($id)) {
    return volver_admin();
}

// Comprobar si el alumno tiene notas.
$pdo = conectar();
$pdo->beginTransaction();
$pdo->exec('LOCK TABLE notas IN SHARE MODE');
$sent = $pdo->prepare("SELECT COUNT(*) 
                       FROM alumnos 
                       JOIN notas 
                       ON alumnos.id=notas.alumno_id
                       WHERE alumnos.id = :id;");
$sent->execute([':id' => $id]);
if ($sent->fetchColumn() === 0) {
    Alumno::borrar($id);
    $_SESSION['exito'] = 'El alumno se ha borrado correctamente.';
    volver_admin();
} else {
    $_SESSION['error'] = 'El alumno tiene notas asociadas.';
    volver_admin();
}

