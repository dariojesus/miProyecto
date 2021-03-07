<style>
    main {
        height: 1000px;
        display: grid;
        grid-template-columns: 80%;
        justify-content: center;
        row-gap: 5%;
        margin-top: 5vh;
        margin-bottom: 5vh;
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
    <main>

        <?php echo CHTML::iniciarForm().PHP_EOL; ?>

        <fieldset>
            <legend>Datos del vuelo</legend>

            <div class="form-floating m-2">

            <?php
                echo CHTML::modeloText($vuelo, "compannia", [
                    "class" => "form-control",
                    "placeholder" => "Compañia",
                    "readonly"=>"readonly"
                ]) . PHP_EOL;
                echo CHTML::modeloLabel($vuelo, "compannia") . PHP_EOL;
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
                echo CHTML::modeloLabel($vuelo, "cod_destino") . PHP_EOL;
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
                echo CHTML::modeloLabel($vuelo, "fecha_salida") . PHP_EOL;
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
                echo CHTML::modeloLabel($vuelo, "hora_salida") . PHP_EOL;
                echo CHTML::modeloError($vuelo, "hora_salida") . PHP_EOL;
                ?>

            </div>

        </fieldset>

        <fieldset>

            <legend>Datos del pasajero</legend>

                <div class="form-floating m-2">

                <?php
                echo CHTML::modeloText($usuario, "nif", [
                    "class" => "form-control",
                    "placeholder" => "NIF",
                    "readonly"=>"readonly"
                ]) . PHP_EOL;
                echo CHTML::modeloLabel($usuario, "nif") . PHP_EOL;
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
                echo CHTML::modeloLabel($usuario, "nombre") . PHP_EOL;
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
                echo CHTML::modeloLabel($usuario, "apellidos") . PHP_EOL;
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
                echo CHTML::modeloLabel($usuario, "email") . PHP_EOL;
                echo CHTML::modeloError($usuario, "email") . PHP_EOL;
                ?>

            </div>
        
        </fieldset>

        <fieldset>

            <legend>Facturación</legend>

            <div class="form-floating m-2">

                <?php

                echo CHTML::campoListaDropDown("clase",0,Clases::dameTiposClases(),[
                    "class" => "form-control",
                    "placeholder" => "Clase",
                    "id"=>"claseSeleccionada"]).PHP_EOL;

                echo CHTML::campoLabel("Clase","clase"). PHP_EOL;
                ?>

            </div>

            <div class="form-floating m-2">

                <?php

                echo CHTML::campoText("precio","",[
                    "class" => "form-control",
                    "placeholder" => "Precio",
                    "id"=>"precio",
                    "readonly"=>"readonly"]).PHP_EOL;

                echo CHTML::campoLabel("Precio","precio"). PHP_EOL;
                ?>

            </div>

            <div class="form-floating m-2">

                <?php
                echo CHTML::campoBotonSubmit("Comprar",array("class"=>"btn btn-outline-success w-100")).PHP_EOL;
                echo CHTML::finalizarForm().PHP_EOL;
                ?>

            </div>

            <div class="form-floating m-2">

                <?php
                echo CHTML::link("Cancelar",$url,array("class"=>"btn btn-outline-danger w-100")).PHP_EOL;
                ?>

            </div>
        </fieldset>
    </main>
</body>