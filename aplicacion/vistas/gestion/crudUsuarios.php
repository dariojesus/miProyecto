<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/imagenes/logo/16.png" />
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
            echo CHTML::link("Gestión de vuelos", ["gestionVuelos","CrudVuelos"], ["class" => "list-group-item list-group-item-action list-group-item-dark"]);

            if ($acceso->hayUsuario())
                echo CHTML::link("Logout", ["logueo", "QuitarRegistro"], ["class" => "list-group-item list-group-item-action list-group-item-danger"]);
            ?>
        </ul>
    </div>
    <main>
        <nav class="barra">
            <a class="nav-link" aria-current="page" id="btnMenu"><img src="/imagenes/logo/menu.png"></a>
        </nav>
        <table class="table table-striped table-hover">
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
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($usr as $clave => $usuario) {

                    //Se crea una ventana modal correspondiente al boton eliminar de cada persona
                    $ventana = new CModal("persona".$usuario["cod_perfil"],
                                          "Borrar usuario",
                                          "Está a punto de borrar el usuario <b>{$usuario["nombre"]} {$usuario["apellidos"]}</b><br>
                                          ¿Seguro que quiere proceder con la operación?",
                                          Sistema::app()->generaURL(array("gestion", "Borrar"),array("codigo" => $usuario["cod_perfil"]))
                                        );

                    $ventana->dibujate();

                    //Se crea una linea de tabla por cada persona
                    echo CHTML::dibujaEtiqueta("tr", ["class" => "persona"], null, false) . PHP_EOL;

                    echo CHTML::dibujaEtiqueta("td", [], $usuario["nif"]) . PHP_EOL;
                    echo CHTML::dibujaEtiqueta("td", [], $usuario["email"]) . PHP_EOL;
                    echo CHTML::dibujaEtiqueta("td", [], $usuario["nombre"]) . PHP_EOL;
                    echo CHTML::dibujaEtiqueta("td", [], $usuario["apellidos"]) . PHP_EOL;
                    echo CHTML::dibujaEtiqueta("td", [], $usuario["fecha_nacimiento"]) . PHP_EOL;
                    echo CHTML::dibujaEtiqueta("td", [], $usuario["poblacion"]) . PHP_EOL;
                    echo CHTML::dibujaEtiqueta("td", [], $usuario["direccion"]) . PHP_EOL;
                    echo CHTML::dibujaEtiqueta("td", [], $usuario["borrado"]) . PHP_EOL;

                    //En contenido se guardan los 3 tipos de enlaces correspondientes a las acciones por cada persona
                    $contenido = CHTML::link(
                        CHTML::imagen("../../../imagenes/iconos/detalles.png"),
                        Sistema::app()->generaURL(
                            array("gestion", "Mostrar"),
                            array("codigo" => $usuario["cod_perfil"])
                        ),
                        array("class" => "btn btn-outline-secondary utilidad", "target" => "miFrame")
                    );

                    $contenido .= CHTML::link(
                        CHTML::imagen("../../../imagenes/iconos/modificar.png"),
                        Sistema::app()->generaURL(
                            array("gestion", "Modificar"),
                            array("codigo" => $usuario["cod_perfil"])
                        ),
                        array("class" => "btn btn-outline-secondary utilidad", "target" => "miFrame")
                    );

                    $contenido .= CHTML::botonHtml(
                        CHTML::imagen("../../../imagenes/iconos/borrar.png"),
                        array("class"=>"btn btn-outline-secondary", 
                        "data-bs-toggle"=>"modal", 
                        "data-bs-target"=>"#persona{$usuario["cod_perfil"]}"));


                    //El contenido (enlaces) se dibuja en la ultima celda de la tabla
                    echo CHTML::dibujaEtiqueta("td", [], $contenido) . PHP_EOL;

                    echo CHTML::dibujaEtiquetaCierre("tr") . PHP_EOL;
                }
                ?>
            </tbody>
        </table>

        <!--Creo mi ventana POP-UP propia para mostrar las páginas de ver y modificar en esta propia página (sin redirecciones)-->
        <div id="fondoFrame">
            <button id="btnFrame">X</button>
            <iframe id="miFrame" name="miFrame"></iframe>
        </div>
    </main>
</body>

</html>