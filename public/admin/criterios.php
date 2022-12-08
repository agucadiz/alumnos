<?php session_start() ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/output.css" rel="stylesheet">
    <title>Criterios</title>
</head>

<body>
    <?php
    require '../../vendor/autoload.php';
    require '../../src/_menu.php'; // Menú login.

    $pdo = conectar();
    $id = obtener_get('id');
    //Consulta para los criterios y calificaciones.
    //Aparte del prepare/execute esta tb el query, consulta simple.
    $sent = $pdo->prepare("SELECT alumno_id, descripcion, nota 
                         FROM notas 
                         JOIN ccee ON notas.ccee_id=ccee.id 
                         WHERE alumno_id = :id 
                         ORDER BY descripcion");
    $sent->execute([':id' => $id]);
    ?>

<div class="container mx-auto relative mt-10 mb-10 shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <th scope="col" class="py-3 px-6">Criterio de Evaluación</th>
                <th scope="col" class="py-3 px-6 text-center">Calificación</th>
            </thead>
            <tbody>
                <?php foreach ($sent as $fila) : ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <!-- CE --> 
                        <td class="py-4 px-6"> <?=hh($fila['descripcion'])?> </a></td>
                        <!-- Calificación -->
                        <td class="py-4 px-6 text-center"> <?=hh($fila['nota'])?> </td>
                    </tr>
                <?php endforeach ?>

            </tbody>
        </table>
    </div>




    <!--JS-->
    <script src="/js/flowbite/flowbite.js"></script>

</body>

</html>