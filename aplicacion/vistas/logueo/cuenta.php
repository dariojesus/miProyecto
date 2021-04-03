<?php $this->lang = $_COOKIE["lang"]; ?>
<main id="cuenta">
    <div>
        <h1><?php echo "<b>".$palabras[0]."</b>";?></h1>
        <h4><?php echo $palabras[1]." <u>".$nombre."</u> ".$palabras[2]; ?></h4>
    </div>

    <section id="seccionCuenta">
        <a href=<?php echo $op["datos"] ?> class="habilitado">
            <img src="../../../imagenes/iconos/usuario.png">
            <p><?php echo $palabras[3];?></p>
        </a>
        <a href=<?php echo $op["proximos"] ?> class="habilitado">
            <img src="../../../imagenes/iconos/nave.png">
            <p><?php echo $palabras[4];?></p>
        </a>
        <a href=<?php echo $op["anteriores"] ?> class="habilitado">
            <img src="../../../imagenes/iconos/billete.png">
            <p><?php echo $palabras[5];?></p>
        </a>
    </section>
</main>