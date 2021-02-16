<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Login</title>
    <meta name="viewport" content="width=device-width; initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous" defer></script>

    <!--Scrip de JQuery-->
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="/estilos/miEstilo.css">
    <script src="/javascript/registro.js" defer></script>
</head>

<style>
    main {
        display: grid;
        grid-template-columns: 80%;
        justify-content: center;
        row-gap: 5%;
        margin-top: 5vh;
    }

    .logo>* {
        display: inline-block;
    }

    html,
    body {
        background-color: white;
    }

    @media (min-width: 600px) {

        fieldset {
            display: grid;
            grid-template-columns: auto auto;
        }

        legend {
            grid-column-start: 1;
            grid-column-end: 3;
        }
    }
</style>

<body>

    <?php
    echo CHTML::iniciarForm("","post",array("class"=>"registro")) . PHP_EOL;
    ?>
    <main>
        <div class="logo">
            <?php
            echo CHTML::link("<img src='../../../imagenes/logo/64.png'>", ["inicial"]);
            echo CHTML::dibujaEtiqueta("h1", [], "Horizons");
            ?>
        </div>

        <fieldset>
            <legend>Datos personales</legend>
            <div class="form-floating m-2">
                <input type="text" class="form-control" id="nif" placeholder="nif">
                <label for="nif">NIF</label>
            </div>
            <div class="form-floating m-2">
                <input type="text" class="form-control" id="nombre" placeholder="nombre" autocomplete="username">
                <label for="nombre">Nombre</label>
            </div>
            <div class="form-floating m-2">
                <input type="text" class="form-control" id="apellidos" placeholder="apellidos">
                <label for="apellidos">Apellidos</label>
            </div>
            <div class="form-floating m-2">
                <input type="date" class="form-control" id="nacimiento" placeholder="nacimiento">
                <label for="nacimiento">Fecha de nacimiento</label>
            </div>
        </fieldset>


        <fieldset>
            <legend>Datos de contacto</legend>
            <div class="form-floating m-2">
                <input type="email" class="form-control" id="email" placeholder="email">
                <label for="email">Email</label>
            </div>

            <div class="form-floating m-2">
                <input type="email" class="form-control" id="emailRepetido" placeholder="email">
                <label for="emailRepetido">Confirmar Email</label>
            </div>

            <div class="form-floating m-2">
                <input class="form-control" list="Opciones" id="poblacion" placeholder="poblacion">
                <datalist id="Opciones">
                    <option value="San Francisco">
                    <option value="New York">
                    <option value="Seattle">
                    <option value="Los Angeles">
                    <option value="Chicago">
                </datalist>
                <label for="poblacion">Poblacion</label>
            </div>

            <div class="form-floating m-2">
                <input type="text" class="form-control" id="direccion" placeholder="direccion">
                <label for="direccion">Direccion</label>
            </div>
        </fieldset>


        <fieldset>
            <legend>Seguridad</legend>
            <div class="form-floating m-2">
                <input type="password" class="form-control" id="contra" placeholder="contraseña" autocomplete="new-password">
                <label for="contra">Contraseña</label>
            </div>
            <div class="form-floating m-2">
                <input type="password" class="form-control" id="contraRepetida" placeholder="contraseña" autocomplete="new-password">
                <label for="contra">Confirmar contraseña</label>
            </div>
        </fieldset>


        <button type="submit" class="btn btn-outline-success w-50" disabled>Registrarse</button>

    </main>
    <?php
    echo CHTML::finalizarForm() . PHP_EOL;
    ?>

</body>
</html>