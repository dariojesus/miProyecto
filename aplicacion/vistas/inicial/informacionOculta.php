<?php

echo CHTML::dibujaEtiqueta("section",["class"=>"info","style"=>"display:none;","id"=>$planeta["nombre"]],null,false).PHP_EOL;

    echo CHTML::dibujaEtiqueta("div",[],null,false).PHP_EOL;

        echo CHTML::dibujaEtiqueta("h1",[],"Destino: ".$planeta["nombre"]).PHP_EOL;
        echo CHTML::dibujaEtiqueta("p",[],"Descripcion: ".$planeta["descripcion"]).PHP_EOL;
        echo CHTML::dibujaEtiqueta("p",[],"Clima: ".$planeta["clima"]).PHP_EOL;
        echo CHTML::dibujaEtiqueta("p",[],"Duración del viaje: ".$planeta["duracion_viaje"]." horas.").PHP_EOL;

    echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;

    foreach ($planeta["vuelos"] as $clave => $vuelo) {
    
    echo CHTML::dibujaEtiqueta("article",[],null,false).PHP_EOL;

        echo CHTML::dibujaEtiqueta("h6",[],"Fecha de salida: ".$vuelo["fecha_salida"]).PHP_EOL;
        echo CHTML::dibujaEtiqueta("h6",[],"Hora de salida: ".$vuelo["hora_salida"]).PHP_EOL;
        echo CHTML::dibujaEtiqueta("h6",[],"Compañia: ".$vuelo["compannia"]).PHP_EOL;
        echo CHTML::dibujaEtiqueta("h6",[],"Plazas restantes: ".$vuelo["plazas"]).PHP_EOL;

    echo CHTML::dibujaEtiquetaCierre("article").PHP_EOL;
}

echo CHTML::dibujaEtiquetaCierre("section").PHP_EOL;

?>