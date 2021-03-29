<main id="cuenta">
    <div>
        <h1>Tu cuenta</h1>
        <h4>Hola <u><?php echo $nombre ?></u> aquí encontrarás toda la información relevante a tu cuenta.</h4>
    </div>

    <section id="seccionCuenta">
        <a href="" class="deshabilitado">
            <img src="../../../imagenes/iconos/usuario.png">
            <p>Mis datos</p>
        </a>
        <a href=<?php echo $link3 ?> class="habilitado">
            <img src="../../../imagenes/iconos/nave.png">
            <p>Proximos viajes</p>
        </a>
        <a href="" class="deshabilitado">
            <img src="../../../imagenes/iconos/billete.png">
            <p>Historial de viajes</p>
        </a>
    </section>
</main>