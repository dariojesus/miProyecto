<?php
$this->textoHead = '<link rel="stylesheet" href="/estilos/destinos.css">';
?>

<section id="planeta">

<?php
    $foto = $planeta->foto;
    echo CHTML::dibujaEtiqueta("article",array("style"=>"background-image: url($foto)", "id"=>"principal"),null,false).PHP_EOL;

        echo CHTML::dibujaEtiqueta("div",array("id"=>"dPlaneta"),null,false).PHP_EOL;
            echo CHTML::dibujaEtiqueta("h2",[],$planeta->nombre).PHP_EOL;
            echo CHTML::dibujaEtiqueta("h6",[],$planeta->descripcion).PHP_EOL;
            echo CHTML::dibujaEtiqueta("h6",[],"Clima: ".$planeta->clima).PHP_EOL;
            echo CHTML::dibujaEtiqueta("h6",[],"Tiempo de viaje: ".$planeta->duracion_viaje." horas.").PHP_EOL;
        echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;

    echo CHTML::dibujaEtiquetaCierre("article").PHP_EOL;

    echo CHTML::dibujaEtiqueta("article",array("id"=>"billetes"),null,false).PHP_EOL;

    echo CHTML::dibujaEtiqueta("div",array("id"=>"filtro"),null,false).PHP_EOL;

    echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;

        echo CHTML::dibujaEtiqueta("section",array("class"=>"billete"),null,false).PHP_EOL;
            
            echo CHTML::dibujaEtiqueta("div",array("class"=>"mitad1"),null,false).PHP_EOL;

                echo CHTML::dibujaEtiqueta("h3",[],"Spacex",true).PHP_EOL;
                echo CHTML::dibujaEtiqueta("h6",[],"Fecha: 01/01/2001",true).PHP_EOL;
                echo CHTML::dibujaEtiqueta("h6",[],"Hora: 15:35",true).PHP_EOL;

            echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;

            echo CHTML::dibujaEtiqueta("div",array("class"=>"mitad2"),null,false).PHP_EOL;
                echo CHTML::imagen("../../../imagenes/iconos/pasajero.png").PHP_EOL;
                echo CHTML::dibujaEtiqueta("h6",[],"20",true).PHP_EOL;
            echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;

        echo CHTML::dibujaEtiquetaCierre("section").PHP_EOL;

    echo CHTML::dibujaEtiquetaCierre("article").PHP_EOL;

?>
</section>