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
</head>
<body>
    <main>
        <?php 
        echo CHTML::iniciarForm($formulario,"POST").PHP_EOL; 
        
        if (isset($errores)){

            echo CHTML::dibujaEtiqueta("fieldset",[],null,false).PHP_EOL;
                echo CHTML::dibujaEtiqueta("legend",array("style"=>"color:red"),"Errores").PHP_EOL;

                foreach ($errores as $campo => $error) 
                    echo CHTML::dibujaEtiqueta("div",array("style"=>"color:red"),$error);

            echo CHTML::dibujaEtiquetaCierre("fieldset").PHP_EOL;
        }
            
        ?>
        <fieldset>
            <legend>Datos generales</legend>

            <div class="form-floating m-2">

                <?php
                echo CHTML::modeloText($modelo, "compannia", [
                    "class" => "form-control",
                    "id" => "compannia",
                    "placeholder" => "Compañia"
                ]) . PHP_EOL;
                echo CHTML::modeloLabel($modelo, "compannia") . PHP_EOL;
                echo CHTML::modeloError($modelo, "compannia") . PHP_EOL;
                ?>

            </div>

            <div class="form-floating m-2">

                <?php
                echo CHTML::modeloDate($modelo, "fecha_salida", [
                    "class" => "form-control",
                    "id" => "fecha",
                    "placeholder" => "Fecha de salida"
                ]) . PHP_EOL;
                echo CHTML::modeloLabel($modelo, "fecha_salida") . PHP_EOL;
                echo CHTML::modeloError($modelo, "fecha_salida") . PHP_EOL;
                ?>

            </div>

            <div class="form-floating m-2">

                <?php
                echo CHTML::modeloTime($modelo, "hora_salida", [
                    "class" => "form-control",
                    "id" => "hora",
                    "placeholder" => "Hora de salida"
                ]) . PHP_EOL;
                echo CHTML::modeloLabel($modelo, "hora_salida") . PHP_EOL;
                echo CHTML::modeloError($modelo, "hora_salida") . PHP_EOL;
                ?>

            </div>
            <div class="form-floating m-2">

                <?php
                echo CHTML::modeloNumber($modelo, "plazas", [
                    "class" => "form-control",
                    "id" => "plazas",
                    "placeholder" => "Plazas"
                ]) . PHP_EOL;
                echo CHTML::modeloLabel($modelo, "plazas") . PHP_EOL;
                echo CHTML::modeloError($modelo, "plazas") . PHP_EOL;
                ?>
            </div>
            <div class="form-floating m-2">

                <?php
                echo CHTML::modeloText($modelo, "cod_destino", [
                    "class" => "form-control",
                    "id" => "destino",
                    "placeholder" => "Destino"
                ]) . PHP_EOL;
                echo CHTML::modeloLabel($modelo, "cod_destino") . PHP_EOL;
                echo CHTML::modeloError($modelo, "cod_destino") . PHP_EOL;
                ?>
            </div>
        </fieldset>

        <fieldset>
            <legend>Datos administrativos</legend>
                <div class="form-floating m-2">

                <?php
                echo CHTML::modeloText($modelo, "borrado", [
                    "class" => "form-control",
                    "id" => "borrado",
                    "placeholder" => "Cancelado"
                ]) . PHP_EOL;
                echo CHTML::modeloLabel($modelo, "borrado") . PHP_EOL;
                echo CHTML::modeloError($modelo, "borrado") . PHP_EOL;
                ?>
            </div>

                <div class="form-floating m-2">

                <?php
                echo CHTML::modeloText($modelo, "cod_vuelo", [
                    "class" => "form-control",
                    "hidden" => "hidden"
                ]) . PHP_EOL;
                ?>
            </div>
        </fieldset>

        <?php 
        echo CHTML::campoBotonSubmit("Modificar",array("class"=>"btn btn-outline-warning")).PHP_EOL;
        echo CHTML::finalizarForm().PHP_EOL;
        ?>
    </main>
</body>

</html>