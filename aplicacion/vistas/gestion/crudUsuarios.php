<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous" defer></script>

    <!--Scrip de JQuery-->
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../../../estilos/cuentas.css">
    <script src="/javascript/miJs.js" defer></script>
</head>

<body>

    <div id="fondo"></div>

    <div id="menu">
        <ul class="list-group list-group-flush">
            <?php
            $acceso = Sistema::app()->acceso();

            if (!$acceso->hayUsuario())
                echo CHTML::link("Iniciar sesion", ["logueo", "formulario"], ["class" => "list-group-item list-group-item-action list-group-item-dark"]);
            else
                echo CHTML::link("Mi cuenta", ["logueo", "MiCuenta"], ["class" => "list-group-item list-group-item-action list-group-item-dark"]);

            echo CHTML::link("Inicio", ["inicial", "Principal"], ["class" => "list-group-item list-group-item-action list-group-item-dark"]);
            echo CHTML::link("Viajes", ["inicial", "Destinos"], ["class" => "list-group-item list-group-item-action list-group-item-dark"]);
            echo CHTML::link("Gestión de usuarios", ["gestion", "CrudUsuarios"], ["class" => "list-group-item list-group-item-action list-group-item-dark"]);

            if ($acceso->hayUsuario())
                echo CHTML::link("Logout", ["logueo", "QuitarRegistro"], ["class" => "list-group-item list-group-item-action list-group-item-danger"]);
            ?>
        </ul>
    </div>
    <main>
        <nav class="barra">
            <a class="nav-link" aria-current="page" id="btnMenu"><img src="/imagenes/logo/menu.png"></a>
        </nav>
        <table class="table table-light table-striped table-hover scroll">
            <thead>
                <tr>
                    <th>NIF</th>
                    <th>Email</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Fecha nacimiento</th>
                    <th>Direccion</th>
                    <th>Poblacion</th>
                    <th>Borrado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>12345678A</td>
                    <td>dariojesusflores@gmail.com</td>
                    <td>Dario Jesus</td>
                    <td>Flores Sevilla</td>
                    <td>18/07/1997</td>
                    <td>Antequera</td>
                    <td>Merecillas n4</td>
                    <td>NO</td>
                </tr>
                <tr>
                    <td>12345678A</td>
                    <td>dariojesusflores@gmail.com</td>
                    <td>Dario Jesus</td>
                    <td>Flores Sevilla</td>
                    <td>18/07/1997</td>
                    <td>Antequera</td>
                    <td>Merecillas n4</td>
                    <td>NO</td>
                </tr>
                <tr>
                    <td>12345678A</td>
                    <td>dariojesusflores@gmail.com</td>
                    <td>Dario Jesus</td>
                    <td>Flores Sevilla</td>
                    <td>18/07/1997</td>
                    <td>Antequera</td>
                    <td>Merecillas n4</td>
                    <td>NO</td>
                </tr>
            </tbody>
        </table>
    </main>
</body>

</html>