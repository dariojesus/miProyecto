<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/imagenes/logo/16.png" />
    <title><?php echo $palabras[23] ?></title>

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

<?php
		$acceso = Sistema::app()->acceso();
		$links = array();
		
		if (!$acceso->hayUsuario())
			$links[] = CHTML::link($palabras[2], ["logueo", "formulario"], ["class" => "list-group-item list-group-item-action list-group-item-dark"]);
		else
			$links[] = CHTML::link($palabras[3], ["logueo", "MiCuenta"], ["class" => "list-group-item list-group-item-action list-group-item-dark"]);
			
		$links[] = CHTML::link($palabras[4], ["inicial", "Principal"], ["class" => "list-group-item list-group-item-action list-group-item-dark"]);
		$links[] = CHTML::link($palabras[5], ["inicial", "Destinos"], ["class" => "list-group-item list-group-item-action list-group-item-dark"]);

		if ($acceso->puedePermisos(2))
			$links[] =CHTML::link($palabras[6], ["gestionVuelos","CrudVuelos"], ["class" => "list-group-item list-group-item-action list-group-item-dark"]);

		if ($acceso->puedePermisos(4))
			$links[] = CHTML::link($palabras[7], ["gestion","CrudUsuarios"], ["class" => "list-group-item list-group-item-action list-group-item-dark"]);
		
		if ($acceso->hayUsuario())
			$links[] = CHTML::link($palabras[8],["logueo","QuitarRegistro"],["class"=>"list-group-item list-group-item-action list-group-item-danger"]);
		
		$menu = new CMenu($links);
		$menu->dibujate();
		?>

    <main>
        <nav class="barra">
            <a class="nav-link" aria-current="page" id="btnMenu"><img src="/imagenes/logo/menu.png"></a>
        </nav>
        <div id="tabla">
            <div style="background-color: black;">
                <?php echo CHTML::link(
                    CHTML::imagen("../../../imagenes/iconos/agregar.png"),
                    Sistema::app()->generaURL(array("gestion", "Agregar")),
                    array("class" => "btn btn-warning m-1 utilidad", "target" => "miFrame")
                ) . PHP_EOL;
                ?>
            </div>
            <table class="table table-striped table-hover" id="tablaUsuarios">
                <thead>
                    <tr>
                        <?php
                        echo CHTML::dibujaEtiqueta("th",[],$palabras[9]).PHP_EOL;
                        echo CHTML::dibujaEtiqueta("th",[],$palabras[10]).PHP_EOL;
                        echo CHTML::dibujaEtiqueta("th",[],$palabras[11]).PHP_EOL;
                        echo CHTML::dibujaEtiqueta("th",[],$palabras[12]).PHP_EOL;
                        echo CHTML::dibujaEtiqueta("th",[],$palabras[13]).PHP_EOL;
                        echo CHTML::dibujaEtiqueta("th",[],$palabras[14]).PHP_EOL;
                        echo CHTML::dibujaEtiqueta("th",[],$palabras[15]).PHP_EOL;
                        echo CHTML::dibujaEtiqueta("th",[],$palabras[16]).PHP_EOL;
                        echo CHTML::dibujaEtiqueta("th",[],$palabras[17]).PHP_EOL;
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($usr as $clave => $usuario) {

                        //Se crea una ventana modal correspondiente al boton eliminar de cada persona
                        $ventana = new CModal(
                            "persona" . $usuario["cod_perfil"],
                            $palabras[18],
                            "$palabras[19]<b>{$usuario["nombre"]} {$usuario["apellidos"]}</b><br>$palabras[20]",
                            Sistema::app()->generaURL(array("gestion", "Borrar"), array("codigo" => $usuario["cod_perfil"])),
                            $palabras[21],$palabras[22]
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
                            array(
                                "class" => "btn btn-outline-secondary",
                                "data-bs-toggle" => "modal",
                                "data-bs-target" => "#persona{$usuario["cod_perfil"]}"
                            )
                        );


                        //El contenido (enlaces) se dibuja en la ultima celda de la tabla
                        echo CHTML::dibujaEtiqueta("td", [], $contenido) . PHP_EOL;

                        echo CHTML::dibujaEtiquetaCierre("tr") . PHP_EOL;
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!--Creo mi ventana POP-UP propia para mostrar las páginas de ver y modificar en esta propia página (sin redirecciones)-->
        <div id="fondoFrame">
            <button id="btnFrame">X</button>
            <iframe id="miFrame" name="miFrame"></iframe>
        </div>
    </main>
</body>

</html>