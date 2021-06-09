<!DOCTYPE html>
<html lang=<?php echo $palabras[0]; ?> >

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $palabras[14]; ?></title>
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
    <link rel="icon" type="image/png" href="/imagenes/logo/16.png"/>

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
    echo CHTML::iniciarForm("","post",array("class"=>"registro")) . PHP_EOL;
    ?>
    <main>
        <div class="logo">
            <?php
            echo CHTML::link("<img src='../../../imagenes/logo/64.png'>", ["inicial"]);
            echo CHTML::dibujaEtiqueta("h1", [],Sistema::app()->empresa);
            ?>
        </div>

        <fieldset>
            <legend><?php echo $palabras[1]; ?></legend>
            <div class="form-floating m-2">

                <?php
                echo CHTML::modeloText($modelo,"nif",["class"=>"form-control",
                                                           "id"=>"nif",
                                                           "placeholder"=>"nif"]).PHP_EOL;
                echo CHTML::campoLabel($palabras[2],"nif").PHP_EOL;
                echo CHTML::modeloError($modelo, "nif").PHP_EOL;
                ?>

            </div>
            <div class="form-floating m-2">

                <?php
                echo CHTML::modeloText($modelo,"nombre",["class"=>"form-control",
                                                           "id"=>"nombre",
                                                           "placeholder"=>"nombre",
                                                           "autocomplete"=>"username"]).PHP_EOL;
                echo CHTML::campoLabel($palabras[3],"nombre").PHP_EOL;
                echo CHTML::modeloError($modelo, "nombre").PHP_EOL;
                ?>

            </div>
            <div class="form-floating m-2">

                <?php
                echo CHTML::modeloText($modelo,"apellidos",["class"=>"form-control",
                                                           "id"=>"apellidos",
                                                           "placeholder"=>"apellidos"]).PHP_EOL;
                echo CHTML::campoLabel($palabras[4],"apellidos").PHP_EOL;
                echo CHTML::modeloError($modelo, "apellidos").PHP_EOL;
                ?>

            </div>
            <div class="form-floating m-2">

                <?php
                echo CHTML::modeloDate($modelo,"fecha_nacimiento",["class"=>"form-control",
                                                           "id"=>"nacimiento",
                                                           "placeholder"=>"nacimiento"]).PHP_EOL;
                echo CHTML::campoLabel($palabras[5],"fecha_nacimiento").PHP_EOL;
                echo CHTML::modeloError($modelo,"fecha_nacimiento").PHP_EOL;
                ?>

            </div>
        </fieldset>


        <fieldset>
            <legend><?php echo $palabras[6]; ?></legend>
            <div class="form-floating m-2">

                <?php
                echo CHTML::modeloEmail($modelo,"email",["class"=>"form-control",
                                                           "id"=>"email",
                                                           "placeholder"=>"email"]).PHP_EOL;
                echo CHTML::campoLabel($palabras[7],"email").PHP_EOL;
                echo CHTML::modeloError($modelo, "email").PHP_EOL;
                ?>

            </div>

            <div class="form-floating m-2">
                <input type="email" class="form-control" id="emailRepetido" placeholder="email">
                <label for="emailRepetido"><?php echo $palabras[8]; ?></label>
            </div>

            <div class="form-floating m-2">

                <?php
                echo CHTML::modeloText($modelo,"poblacion",["class"=>"form-control",
                                                           "id"=>"poblacion",
                                                           "placeholder"=>"poblacion",
                                                           "list"=>"opciones"]).PHP_EOL;
                echo CHTML::campoLabel($palabras[9],"poblacion").PHP_EOL;
                echo CHTML::modeloError($modelo, "poblacion").PHP_EOL;
                ?>

            </div>

            <div class="form-floating m-2">

                <?php
                echo CHTML::modeloText($modelo,"direccion",["class"=>"form-control",
                                                           "id"=>"direccion",
                                                           "placeholder"=>"direccion"]).PHP_EOL;
                echo CHTML::campoLabel($palabras[10],"direccion").PHP_EOL;
                echo CHTML::modeloError($modelo, "direccion").PHP_EOL;
                ?>

            </div>
        </fieldset>


        <fieldset>
            <legend><?php echo $palabras[11]; ?></legend>
            <div class="form-floating m-2">

                <?php
                echo CHTML::campoPassword("contrasenna","",["class"=>"form-control",
                                                            "id"=>"contra",
                                                            "placeholder"=>"contraseña",
                                                            "autocomplete"=>"new-password"]).PHP_EOL;
                echo CHTML::campoLabel($palabras[12],"contrasenna").PHP_EOL;

                if (!empty($error))
                    echo CHTML::dibujaEtiqueta("div",["class"=>"error"],$error);
                ?>

            </div>
            <div class="form-floating m-2">
                <input type="password" class="form-control" id="contraRepetida" placeholder="contraseña" autocomplete="new-password">
                <label for="contra"><?php echo $palabras[13]; ?></label>
            </div>
        </fieldset>

        <?php echo CHTML::campoBotonSubmit($palabras[14],["class"=>"btn btn-outline-success w-50"])?>

    </main>
    <?php
    echo CHTML::finalizarForm() . PHP_EOL;
    ?>

</body>
</html>