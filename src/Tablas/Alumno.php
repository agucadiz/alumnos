<?php

namespace App\Tablas;

use PDO;

class Alumno
{
    public $id;
    public $nombre;
    public $fecha_nac;

    public function __construct(array $campos)
    {
        $this->id = $campos['id'];
        $this->nombre = $campos['nombre'];
        $this->fecha_nac = $campos['fecha_nac'];
    }

    public static function insertar($nombre, $fecha_nac, ?PDO $pdo = null)
    {
        $pdo = $pdo ?? conectar();

        $sent = $pdo->prepare('INSERT INTO alumnos (nombre, fecha_nac)
                                    VALUES (:nombre, :fecha_nac)');
        $sent->execute([':nombre' => $nombre, ':fecha_nac' => $fecha_nac]);
    }

    public static function modificar($id, $nombre, $fecha_nac, ?PDO $pdo = null)
    {
        $pdo = $pdo ?? conectar();

        $sent = $pdo->prepare("UPDATE alumnos 
                                  SET nombre = :nombre, fecha_nac = :fecha_nac
                                WHERE id = :id");
        $sent->execute([':id' => $id, ':nombre' => $nombre, 'fecha_nac' => $fecha_nac]);
    }

    public static function borrar($id, ?PDO $pdo = null)
    {
        $pdo = $pdo ?? conectar();

        $sent = $pdo->prepare("DELETE FROM alumnos
                                     WHERE id = :id");
        $sent->execute([':id' => $id]);
    }
}
