<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Login</title>
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
    <link rel="icon" type="image/png" href="/imagenes/logo/16.png" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous" defer></script>

    <!--Scrip de JQuery-->
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
</head>
<style>
    body {
        margin-top: 2%;
        height: 100%;
        width: 100%;

        display: grid;
        grid-template-columns: 100%;
        grid-template-rows: repeat(3, 33%);
        row-gap: 2%;
    }
</style>

<body>

    <?php

    echo CHTML::link("Detalles", Sistema::app()->generaURL(array("gestion", "Mostrar"), array("codigo" => $codigo)), array("class" => "btn btn-success"));

    echo CHTML::link("Modificar", Sistema::app()->generaURL(array("gestion", "Modificar"), array("codigo" => $codigo)), array("class" => "btn btn-warning"));

    echo CHTML::link("Eliminar", Sistema::app()->generaURL(array("gestion", "Borrar"), array("codigo" => $codigo)), array("class" => "btn btn-danger"));

    ?>

</body>

</html>