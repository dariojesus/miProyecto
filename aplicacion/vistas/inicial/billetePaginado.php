<?php

echo CHTML::dibujaEtiqueta("section",array("class"=>"billete","data-location"=>$enlace),null,false).PHP_EOL;
            
    echo CHTML::dibujaEtiqueta("div",array("class"=>"mitad1"),null,false).PHP_EOL;

        echo CHTML::dibujaEtiqueta("h3",[],$vuelo["compannia"],true).PHP_EOL;

        echo CHTML::dibujaEtiqueta("h6",[],"Fecha: ".CGeneral::fechaMysqlANormal($vuelo["fecha_salida"]),true).PHP_EOL;
        echo CHTML::dibujaEtiqueta("h6",[],"Hora: {$vuelo["hora_salida"]}",true).PHP_EOL;

    echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;

    echo CHTML::dibujaEtiqueta("div",array("class"=>"mitad2"),null,false).PHP_EOL;
        echo CHTML::imagen("../../../imagenes/iconos/pasajero.png").PHP_EOL;
        echo CHTML::dibujaEtiqueta("h6",[],"{$vuelo["plazas"]}",true).PHP_EOL;
    echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;

echo CHTML::dibujaEtiquetaCierre("section").PHP_EOL;

?>