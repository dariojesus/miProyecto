<?php

echo CHTML::dibujaEtiqueta("section",["class"=>"info","style"=>"display:none;","id"=>$planeta["nombre"]],null,false).PHP_EOL;

    echo CHTML::dibujaEtiqueta("div",[],null,false).PHP_EOL;

        echo CHTML::dibujaEtiqueta("h1",[],"Destino: ".$planeta["nombre"]).PHP_EOL;
        echo CHTML::dibujaEtiqueta("p",[],"Descripcion: ".$planeta["descripcion"]).PHP_EOL;
        echo CHTML::dibujaEtiqueta("p",[],"Clima: ".$planeta["clima"]).PHP_EOL;
        echo CHTML::dibujaEtiqueta("p",[],"Duración del viaje: ".$planeta["duracion_viaje"]." horas.").PHP_EOL;

    echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;

echo CHTML::dibujaEtiquetaCierre("section").PHP_EOL;

?>