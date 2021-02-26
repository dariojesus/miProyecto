<?php
    /*Se crean las tarjetas de los planetas con su información mínima */
    $foto = $planeta["foto"];

    echo CHTML::dibujaEtiqueta("div",["class"=>"destino", "style"=>"background-image: url($foto)"],null,false).PHP_EOL;

        echo CHTML::dibujaEtiqueta("div",["class"=>"datos"],null,false).PHP_EOL;

            echo CHTML::dibujaEtiqueta("h2",[],$planeta["nombre"]);
            echo CHTML::dibujaEtiqueta("p",[],"Duración del viaje: ".$planeta["duracion_viaje"]." horas.");

        echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;

    echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;
?>