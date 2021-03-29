<?php
$this->textoHead = '<link rel="stylesheet" href="/estilos/formularios.css"> <script src="/javascript/registro.js" defer></script>'
?>

<main>
    <form method="post">
        <fieldset>
            <legend>Datos de la cuenta</legend>

            <div class="form-floating m-2">

                <?php
                echo CHTML::modeloText($modelo, "nif", [
                    "class" => "form-control",
                    "placeholder" => "nif",
                    "readonly" => "readonly"
                ]) . PHP_EOL;
                echo CHTML::modeloLabel($modelo, "nif") . PHP_EOL;
                ?>

            </div>

            <div class="form-floating m-2">

                <?php
                echo CHTML::campoText("rol",$rol,[
                                        "class" => "form-control",
                                        "placeholder" => "Tipo usuario",
                                        "readonly" => "readonly"
                                        ]).PHP_EOL;
                echo CHTML::campoLabel("Tipo usuario","rol").PHP_EOL;
                ?>

            </div>

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
                    "placeholder" => "poblacion"
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

            <legend>Modificar contraseña</legend>

            <div class="form-floating m-2">
                <?php
                echo CHTML::campoPassword("newPass", "", [
                    "class" => "form-control",
                    "id" => "contra",
                    "placeholder" => "contraseña",
                    "autocomplete" => "new-password"
                ]) . PHP_EOL;
                echo CHTML::campoLabel("Nueva contraseña", "contrasenna") . PHP_EOL;

                if (!empty($error))
                    echo CHTML::dibujaEtiqueta("div", ["class" => "error"], $error);
                ?>
            </div>

            <div class="form-floating m-2">
                <?php
                echo CHTML::campoPassword("oldPass", "", [
                    "class" => "form-control",
                    "placeholder" => "contraseña",
                    "autocomplete" => "new-password"
                ]) . PHP_EOL;
                echo CHTML::campoLabel("Contraseña actual", "contrasenna") . PHP_EOL;

                if (!empty($error))
                    echo CHTML::dibujaEtiqueta("div", ["class" => "error"], $error);
                ?>
            </div>

        </fieldset>
        <div>
            <?php echo CHTML::campoBotonSubmit("Guardar",["class"=>"btn btn-outline-success"])?>
        </div>
    </form>
</main>