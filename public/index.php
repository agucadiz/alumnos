<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/output.css" rel="stylesheet">
    <title>Alumnos</title>
</head>

<body>

    <?php
    require '../vendor/autoload.php';

    $pdo = conectar();
    $sent = $pdo->query("SELECT * FROM alumnos ORDER BY id");
    ?>


    <div class="container mx-auto relative mt-6 shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <th scope="col" class="py-3 px-6">Nombre</th>
                <th scope="col" class="py-3 px-6 text-center">Opciones</th>
            </thead>
            <tbody>
                <?php foreach ($sent as $fila) : ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="py-4 px-6"><?= hh($fila['nombre']) ?></td>

                        <td class="py-4 px-6 text-center">
                            <a href="modificar.php?id=<?= $fila['id'] ?>&nombrem=<?= $fila['nombre'] ?>" class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">Editar</a>
                            <form action="borrar.php" method="POST" class="inline">
                                <input type="hidden" name="id" value="<?= hh($fila['id']) ?>">
                                <button type="submit" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Borrar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>

                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td></td>
                    <td class="py-4 px-6 text-center">
                        <a href="añadir.php" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Añadir alumno</a>
                </tr>
            </tbody>
        </table>
    </div>

    <script src="/js/flowbite/flowbite.js"></script>

</body>

</html>