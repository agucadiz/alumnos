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

</body>

</html>