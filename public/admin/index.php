<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/output.css" rel="stylesheet">
    <script>
        function cambiar(el, id) {
            el.preventDefault();
            const oculto = document.getElementById('oculto');
            oculto.setAttribute('value', id);
        }
    </script>
    <title>Alumnos</title>
</head>

<body>

    <?php
    require '../../vendor/autoload.php';
    require '../../src/_menu.php'; // Menú login.
    require_once '../../src/_alerts.php'; //alertas error y exito.


    $nombre = obtener_get('nombre');
    ?>

    <!-- Buscador de alumnos -->
    <div class="container mx-auto mt-10">
        <h1 class="block mb-2 text-base font-black text-gray-900 dark:text-white">Búsqueda</h1>
        <form action="" method="get">
            <div class="mb-2">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Nombre:
                    <input type="text" name="nombre" value="<?= hh($nombre) ?>" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-50 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                </label>
            </div>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Buscar</button>
        </form>
    </div>
    <?php
    $pdo = conectar();
    $pdo->beginTransaction();
    $pdo->exec('LOCK TABLE alumnos IN SHARE MODE');
    $where = [];
    $execute = [];
    if (isset($nombre) && $nombre != '') {
        $where[] = 'lower(nombre) LIKE lower(:nombre)';
        $execute[':nombre'] = "%$nombre%";
    }
    $where = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';
    //Consulta buscador.
    $sent = $pdo->prepare("SELECT COUNT(*) FROM alumnos $where");
    $sent->execute($execute);
    $total = $sent->fetchColumn();
    //Consulta tabla. Nota final.
    $sent = $pdo->prepare("SELECT alumnos.id, nombre, ROUND(AVG(nota),2) 
                           FROM alumnos LEFT JOIN notas ON alumnos.id=notas.alumno_id 
                           $where 
                           GROUP BY alumnos.id 
                           ORDER BY alumnos.id");
    $sent->execute($execute);
    $pdo->commit();
    ?>

    <!-- Tabla alumnos  -->
    <div class="container mx-auto relative mt-10 mb-10 shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <th scope="col" class="py-3 px-6">Nombre</th>
                <th scope="col" class="py-3 px-6">Nota</th>
                <th scope="col" class="py-3 px-6 text-center">Opciones</th>
            </thead>
            <tbody>
                <?php foreach ($sent as $fila) : ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <!-- Nombre alumno y link a criterios--> 
                        <td class="py-4 px-6"><a href="criterios.php?id=<?= $fila['id'] ?>"> <?=hh($fila['nombre'])?> </a></td>
                        <!-- Nota -->
                        <td class="py-4 px-6"> <?=hh($fila['round'])?> </td>
                        <td class="py-4 px-6 text-center">
                            <!-- Modificar alumnos  -->
                            <a href="modificar.php?id=<?= $fila['id'] ?>&nombrem=<?= $fila['nombre'] ?>" class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">
                                Editar</a>
                            <!-- Eliminar alumnos  -->
                            <form action="borrar.php" method="POST" class="inline">
                                <input type="hidden" name="id" value="<?= hh($fila['id']) ?>">
                                <button type="submit" onclick="cambiar(event, <?= hh($fila['id']) ?>)" data-modal-toggle="popup-modal-borrar" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
                                    Borrar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>

                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <!-- Total alumnos -->
                    <td>Número total de filas: <?= hh($total) ?></td>
                    <td></td>
                    <td class="py-4 px-6 text-center">
                        <!-- Insertar Alumnos -->
                        <a href="insertar.php" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                            Insertar alumno
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Ventana modal Borrar-->
    <div id="popup-modal-borrar" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="popup-modal-borrar">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Cerrar ventana</span>
                </button>
                <div class="p-6 text-center">
                    <svg aria-hidden="true" class="mx-auto mb-4 w-14 h-14 text-gray-400 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">¿Seguro que desea borrar este alumno?</h3>
                    <form action="borrar.php" method="POST">
                        <input id="oculto" type="hidden" name="id">
                        <button data-modal-toggle="popup-modal-borrar" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Sí, seguro
                        </button>
                        <button data-modal-toggle="popup-modal-borrar" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                            No, cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--JS-->
    <script src="/js/flowbite/flowbite.js"></script>

</body>

</html>