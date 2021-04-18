<?php

echo CHTML::dibujaEtiqueta("section",array("class"=>"billete","data-location"=>$enlace),null,false).PHP_EOL;
            
    echo CHTML::dibujaEtiqueta("h3",["class"=>"titulo"],$vuelo["compannia"],true).PHP_EOL;

    echo CHTML::dibujaEtiqueta("div",array("class"=>"lateral"),null,false).PHP_EOL;
        echo CHTML::imagen("../../../imagenes/iconos/pasajero.png").PHP_EOL;
        echo CHTML::dibujaEtiqueta("p",[],"{$vuelo["plazas"]}",true).PHP_EOL;
    echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;

    echo CHTML::dibujaEtiqueta("h6",[],$palabras[6].": <br>".CGeneral::fechaMysqlANormal($vuelo["fecha_salida"]),true).PHP_EOL;
    echo CHTML::dibujaEtiqueta("h6",[],$palabras[7].": <br>".$vuelo["hora_salida"],true).PHP_EOL;

    echo CHTML::dibujaEtiqueta("h6",[],$palabras[8].": <br>".CGeneral::fechaMysqlANormal($vuelo["fecha_llegada"]),true).PHP_EOL;
    echo CHTML::dibujaEtiqueta("h6",[],$palabras[9].": <br>".$vuelo["hora_llegada"],true).PHP_EOL;

echo CHTML::dibujaEtiquetaCierre("section").PHP_EOL;

?>