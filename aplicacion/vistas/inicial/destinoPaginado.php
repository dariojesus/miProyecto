<?php
    /*Se crean las tarjetas de los planetas con su información mínima */
    echo CHTML::dibujaEtiqueta("div",["class"=>"destinoPaisaje", "style"=>"background-image: url({$planeta[3]})", "data-location"=>$datos],null,false).PHP_EOL;

        echo CHTML::dibujaEtiqueta("div",["class"=>"datos"],null,false).PHP_EOL;

            echo CHTML::dibujaEtiqueta("h2",[],$planeta[1]);
            echo CHTML::dibujaEtiqueta("p",[],$palabras[1].$planeta[2].$palabras[2]);

        echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;

    echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;
?>