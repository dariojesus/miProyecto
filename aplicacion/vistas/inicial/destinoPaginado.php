<?php
    /*Se crean las tarjetas de los planetas con su información mínima */
    $foto = $planeta["foto"];

    echo CHTML::dibujaEtiqueta("div",["class"=>"destinoPaisaje", "style"=>"background-image: url($foto)", "data-location"=>$datos],null,false).PHP_EOL;

        echo CHTML::dibujaEtiqueta("div",["class"=>"datos"],null,false).PHP_EOL;

            echo CHTML::dibujaEtiqueta("h2",[],$planeta["nombre"]);
            echo CHTML::dibujaEtiqueta("p",[],$palabras[1].$planeta["duracion_viaje"].$palabras[2]);

        echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;

    echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;
?>