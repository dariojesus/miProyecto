<?php 
    $this->textoHead = "<link rel='stylesheet' href='/estilos/formularios.css'>"; 
    $this->lang = $palabras[0];
?>
<body>
    <main>

        <?php echo CHTML::iniciarForm().PHP_EOL; ?>

        <fieldset>
            <legend><?php echo $palabras[1]; ?></legend>

            <div class="form-floating m-2">

            <?php
                echo CHTML::modeloText($vuelo, "compannia", [
                    "class" => "form-control",
                    "placeholder" => "Compañia",
                    "readonly"=>"readonly"
                ]) . PHP_EOL;
                echo CHTML::campoLabel($palabras[2], "compannia") . PHP_EOL;
                echo CHTML::modeloError($vuelo, "compannia") . PHP_EOL;
                ?>

            </div>
            <div class="form-floating m-2">

                <?php
                echo CHTML::modeloText($vuelo, "cod_destino", [
                    "class" => "form-control",
                    "placeholder" => "Destino",
                    "readonly"=>"readonly"
                ]) . PHP_EOL;
                echo CHTML::campoLabel($palabras[3], "cod_destino") . PHP_EOL;
                echo CHTML::modeloError($vuelo, "cod_destino") . PHP_EOL;
                ?>

            </div>
            <div class="form-floating m-2">

                <?php
                echo CHTML::modeloText($vuelo, "fecha_salida", [
                    "class" => "form-control",
                    "placeholder" => "Fecha de salida",
                    "readonly"=>"readonly"
                ]) . PHP_EOL;
                echo CHTML::campoLabel($palabras[4], "fecha_salida") . PHP_EOL;
                echo CHTML::modeloError($vuelo, "fecha_salida") . PHP_EOL;
                ?>

            </div>
            <div class="form-floating m-2">

                <?php
                echo CHTML::modeloTime($vuelo, "hora_salida", [
                    "class" => "form-control",
                    "placeholder" => "Hora de salida",
                    "readonly"=>"readonly"
                ]) . PHP_EOL;
                echo CHTML::campoLabel($palabras[5], "hora_salida") . PHP_EOL;
                echo CHTML::modeloError($vuelo, "hora_salida") . PHP_EOL;
                ?>

            </div>

        </fieldset>

        <fieldset>

            <legend><?php echo $palabras[6]; ?></legend>

                <div class="form-floating m-2">

                <?php
                echo CHTML::modeloText($usuario, "nif", [
                    "class" => "form-control",
                    "placeholder" => "NIF",
                    "readonly"=>"readonly"
                ]) . PHP_EOL;
                echo CHTML::campoLabel($palabras[7], "nif") . PHP_EOL;
                echo CHTML::modeloError($usuario, "nif") . PHP_EOL;
                ?>

            </div>

            <div class="form-floating m-2">

                <?php
                echo CHTML::modeloText($usuario, "nombre", [
                    "class" => "form-control",
                    "placeholder" => "Nombre",
                    "readonly"=>"readonly"
                ]) . PHP_EOL;
                echo CHTML::campoLabel($palabras[8], "nombre") . PHP_EOL;
                echo CHTML::modeloError($usuario, "nombre") . PHP_EOL;
                ?>

            </div>

            <div class="form-floating m-2">

                <?php
                echo CHTML::modeloText($usuario, "apellidos", [
                    "class" => "form-control",
                    "placeholder" => "Apellidos",
                    "readonly"=>"readonly"
                ]) . PHP_EOL;
                echo CHTML::campoLabel($palabras[9], "apellidos") . PHP_EOL;
                echo CHTML::modeloError($usuario, "apellidos") . PHP_EOL;
                ?>

            </div>

            <div class="form-floating m-2">

                <?php
                echo CHTML::modeloText($usuario, "email", [
                    "class" => "form-control",
                    "placeholder" => "Email",
                    "readonly"=>"readonly"
                ]) . PHP_EOL;
                echo CHTML::campoLabel($palabras[10], "email") . PHP_EOL;
                echo CHTML::modeloError($usuario, "email") . PHP_EOL;
                ?>

            </div>
        
        </fieldset>

        <fieldset>

            <legend><?php echo $palabras[11]; ?></legend>

            <div class="form-floating m-2">

                <?php

                echo CHTML::campoListaDropDown("clase",0,Clases::dameTiposClases($_COOKIE["lang"]),[
                    "class" => "form-control",
                    "placeholder" => "Clase",
                    "id"=>"claseSeleccionada"]).PHP_EOL;

                echo CHTML::campoLabel($palabras[12],"clase"). PHP_EOL;
                ?>

            </div>

            <div class="form-floating m-2">

                <?php

                echo CHTML::campoText("precio","",[
                    "class" => "form-control",
                    "placeholder" => "Precio",
                    "id"=>"precio",
                    "readonly"=>"readonly"]).PHP_EOL;

                echo CHTML::campoLabel($palabras[13],"precio"). PHP_EOL;
                ?>

            </div>

            <div class="form-floating m-2">

                <?php
                echo CHTML::campoBotonSubmit($palabras[14],array("class"=>"btn btn-outline-success w-100")).PHP_EOL;
                echo CHTML::finalizarForm().PHP_EOL;
                ?>

            </div>

            <div class="form-floating m-2">

                <?php
                echo CHTML::link($palabras[15],$url,array("class"=>"btn btn-outline-danger w-100")).PHP_EOL;
                ?>

            </div>
        </fieldset>
    </main>
</body>