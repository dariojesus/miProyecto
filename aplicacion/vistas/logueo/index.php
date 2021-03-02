<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Login</title>
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
    <link rel="icon" type="image/png" href="/imagenes/logo/16.png"/>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous" defer></script>

    <!--Scrip de JQuery-->
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="/estilos/miEstilo.css">
    <script src="/javascript/miJs.js" defer></script>
</head>

<body>

    <?php
    echo CHTML::iniciarForm() . PHP_EOL;

    echo CHTML::dibujaEtiqueta("main", ["class" => "login"], null, false) . PHP_EOL;

    echo CHTML::dibujaEtiqueta("div", ["class" => "logo"], null, false) . PHP_EOL;
    echo CHTML::link("<img src='../../../imagenes/logo/64.png'>", ["inicial"]) . PHP_EOL;
    echo CHTML::dibujaEtiqueta("h1", [], "Horizons") . PHP_EOL;
    echo CHTML::dibujaEtiquetaCierre("div") . PHP_EOL;

    echo CHTML::dibujaEtiqueta("div", ["class" => "form-floating"], null, false) . PHP_EOL;
    echo CHTML::modeloText($modelo, "nif", array(
                                                    "class" => "form-control",
                                                    "placeholder" => "identificacion",
                                                    "autocomplete" => "username",
                                                    "id" => "logNombre"
                                                )) . PHP_EOL;
    echo CHTML::modeloLabel($modelo,"nif") . PHP_EOL;
    echo CHTML::modeloError($modelo,"nif",["class"=>"error"]);
    echo CHTML::dibujaEtiquetaCierre("div") . PHP_EOL;


    echo CHTML::dibujaEtiqueta("div", ["class" => "form-floating"], null, false) . PHP_EOL;
    echo CHTML::modeloPassword($modelo, "contrasenna", array(
                                                    "class" => "form-control",
                                                    "placeholder" => "contra",
                                                    "autocomplete" => "current-password"
                                                )) . PHP_EOL;
    echo CHTML::modeloLabel($modelo, "contrasenna") . PHP_EOL;
    echo CHTML::modeloError($modelo,"contrasenna",["class"=>"error"]);
    echo CHTML::dibujaEtiquetaCierre("div") . PHP_EOL;

    echo CHTML::dibujaEtiqueta("div", ["class"=>"form-check"], null, false) . PHP_EOL;
    echo CHTML::campoCheckBox("recordar",true,["class"=>"form-check-input","id"=>"recordar"]).PHP_EOL;
    echo CHTML::campoLabel("Recordar usuario y contraseña","recordar",["class"=>"form-check-label"]).PHP_EOL;
    echo CHTML::dibujaEtiquetaCierre("div") . PHP_EOL;

    echo CHTML::dibujaEtiqueta("div", [], null, false) . PHP_EOL;
    echo CHTML::campoBotonSubmit("Acceder", ["class" => "btn btn-dark","id"=>"acceder"]) . PHP_EOL;
    echo CHTML::link("Registrarse", ["logueo", "Registro"], ["class" => "btn btn-dark"]) . PHP_EOL;
    echo CHTML::dibujaEtiquetaCierre("div") . PHP_EOL;
    echo CHTML::finalizarForm() . PHP_EOL;

    echo CHTML::dibujaEtiqueta("hr") . PHP_EOL;

    echo CHTML::botonHtml("Login mediante Google", ["class" => "btn btn-outline-warning"]) . PHP_EOL;
    echo CHTML::botonHtml("Login mediante Facebook", ["class" => "btn btn-outline-primary"]) . PHP_EOL;
    echo CHTML::dibujaEtiquetaCierre("main") . PHP_EOL;
    ?>
</body>

</html>