<?php

echo CHTML::dibujaEtiqueta("section",array("class"=>"billete","data-location"=>$enlace),null,false).PHP_EOL;
            
    echo CHTML::dibujaEtiqueta("h4",["class"=>"titulo"],$vuelo["compannia"],true).PHP_EOL;

    echo CHTML::dibujaEtiqueta("div",array("class"=>"lateral"),null,false).PHP_EOL;
        echo CHTML::imagen("../../../imagenes/iconos/pasajero.png").PHP_EOL;
        echo CHTML::dibujaEtiqueta("p",[],"{$vuelo["plazas"]}",true).PHP_EOL;
    echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;    

    echo CHTML::dibujaEtiqueta("h6",[],$palabras[6].": ".CGeneral::fechaMysqlANormal($vuelo["fecha_salida"]),true).PHP_EOL;
    echo CHTML::dibujaEtiqueta("h6",[],$palabras[7].": ".$vuelo["hora_salida"],true).PHP_EOL;

    echo CHTML::dibujaEtiqueta("h6",[],$palabras[8].": ".CGeneral::fechaMysqlANormal($vuelo["fecha_llegada"]),true).PHP_EOL;
    echo CHTML::dibujaEtiqueta("h6",[],$palabras[9].": ".$vuelo["hora_llegada"],true).PHP_EOL;

echo CHTML::dibujaEtiquetaCierre("section").PHP_EOL;

?>