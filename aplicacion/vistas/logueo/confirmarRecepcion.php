<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Recuperación de contraseña</title>
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
    <link rel="icon" type="image/png" href="/imagenes/logo/16.png" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous" defer></script>

    <!--Scrip de JQuery-->
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="/estilos/miEstilo.css">
    <link rel="stylesheet" href="/estilos/formularios.css">
    <script src="/javascript/registro.js" defer></script>
</head>

<body>

    <?php
    echo CHTML::iniciarForm() . PHP_EOL;
    echo CHTML::dibujaEtiqueta("main", ["class" => "login"], null, false) . PHP_EOL;
    echo CHTML::dibujaEtiqueta("div", ["class" => "logo"], null, false) . PHP_EOL;
    echo CHTML::link("<img src='../../../imagenes/logo/64.png'>", ["inicial"]);
    echo CHTML::dibujaEtiqueta("h1", [], Sistema::app()->empresa);
    echo CHTML::dibujaEtiquetaCierre("div") . PHP_EOL;

    echo CHTML::dibujaEtiqueta("div", ["class" => "form-floating m-2"], null, false) . PHP_EOL;
    echo CHTML::dibujaEtiqueta("p",[],"Revise su bandeja de entrada y confirme si ha recibido un correo de recuperación de contraseña de nuestro equipo.").PHP_EOL;
    echo CHTML::dibujaEtiquetaCierre("div") . PHP_EOL;

    echo CHTML::dibujaEtiqueta("div", ["class" => "m-2"], null, false) . PHP_EOL;
    echo CHTML::campoBotonSubmit("Email recibido", ["class" => "btn btn-outline-success"]) . PHP_EOL;
    echo CHTML::link("Cancelar", ["logueo", "Formulario"], ["class" => "btn btn-outline-danger"]) . PHP_EOL;
    echo CHTML::dibujaEtiquetaCierre("div") . PHP_EOL;

    echo CHTML::dibujaEtiquetaCierre("main") . PHP_EOL;
    echo CHTML::finalizarForm();

    ?>
</body>

</html>