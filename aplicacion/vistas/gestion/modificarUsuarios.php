<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Información de usuario</title>
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
    ?>
    <main>

        <fieldset>
            <legend>Datos personales</legend>

            <div class="form-floating m-2">

                <?php
                echo CHTML::modeloText($modelo, "nif", [
                    "class" => "form-control",
                    "id" => "nif",
                    "placeholder" => "nif"
                ]) . PHP_EOL;
                echo CHTML::modeloLabel($modelo, "nif") . PHP_EOL;
                echo CHTML::modeloError($modelo, "nif") . PHP_EOL;
                ?>

            </div>
            <div class="form-floating m-2">

                <?php
                echo CHTML::modeloText($modelo, "nombre", [
                    "class" => "form-control",
                    "id" => "nombre",
                    "placeholder" => "nombre",
                    "autocomplete" => "username"
                ]) . PHP_EOL;
                echo CHTML::modeloLabel($modelo, "nombre") . PHP_EOL;
                echo CHTML::modeloError($modelo, "nombre") . PHP_EOL;
                ?>

            </div>
            <div class="form-floating m-2">

                <?php
                echo CHTML::modeloText($modelo, "apellidos", [
                    "class" => "form-control",
                    "id" => "apellidos",
                    "placeholder" => "apellidos"
                ]) . PHP_EOL;
                echo CHTML::modeloLabel($modelo, "apellidos") . PHP_EOL;
                echo CHTML::modeloError($modelo, "apellidos") . PHP_EOL;
                ?>

            </div>
            <div class="form-floating m-2">

                <?php
                echo CHTML::modeloDate($modelo, "fecha_nacimiento", [
                    "class" => "form-control",
                    "id" => "nacimiento",
                    "placeholder" => "nacimiento"
                ]) . PHP_EOL;
                echo CHTML::modeloLabel($modelo, "fecha_nacimiento") . PHP_EOL;
                echo CHTML::modeloError($modelo, "fecha_nacimiento") . PHP_EOL;
                ?>

            </div>

        </fieldset>


        <fieldset>
            <legend>Datos de contacto</legend>

            <div class="form-floating m-2">

                <?php
                echo CHTML::modeloEmail($modelo, "email", [
                    "class" => "form-control",
                    "id" => "email",
                    "placeholder" => "email"
                ]) . PHP_EOL;
                echo CHTML::modeloLabel($modelo, "email") . PHP_EOL;
                echo CHTML::modeloError($modelo, "email") . PHP_EOL;
                ?>

            </div>

            <div class="form-floating m-2">

                <?php
                echo CHTML::modeloText($modelo, "poblacion", [
                    "class" => "form-control",
                    "id" => "poblacion",
                    "placeholder" => "poblacion",
                    "list" => "opciones"
                ]) . PHP_EOL;
                echo CHTML::modeloLabel($modelo, "poblacion") . PHP_EOL;
                echo CHTML::modeloError($modelo, "poblacion") . PHP_EOL;
                ?>

            </div>

            <div class="form-floating m-2">

                <?php
                echo CHTML::modeloText($modelo, "direccion", [
                    "class" => "form-control",
                    "id" => "direccion",
                    "placeholder" => "direccion"
                ]) . PHP_EOL;
                echo CHTML::modeloLabel($modelo, "direccion") . PHP_EOL;
                echo CHTML::modeloError($modelo, "direccion") . PHP_EOL;
                ?>

            </div>

        </fieldset>

        <fieldset>
            <legend>Datos de cuenta</legend>

                <div class="form-floating m-2">

                <?php

                $datos = array(0=>"No", 1=>"Si");

                echo CHTML::modeloListaDropDown($modelo,"borrado",$datos,
                                                ["class" => "form-control w-50",
                                                "placeholder" => "borrado"]) . PHP_EOL;

                echo CHTML::modeloLabel($modelo, "borrado") . PHP_EOL;
                echo CHTML::modeloError($modelo, "borrado") . PHP_EOL;
                ?>

            </div>
        
        </fieldset>

        <div class="form-floating m-2">

            <?php
            echo CHTML::modeloNumber($modelo,"cod_perfil",array("hidden"=>"hidden"));
            echo CHTML::campoBotonSubmit("Modificar", ["class" => "btn btn-outline-warning w-50", "name" => "modifica"]) . PHP_EOL;
            ?>

    </main>
    <?php
    echo CHTML::finalizarForm() . PHP_EOL;
    ?>

</body>

</html>