<?php
$this->textoHead = '<link rel="stylesheet" href="/estilos/destinos.css">';
?>

<section id="planeta">

    <?php
    $foto = $planeta->foto;
    echo CHTML::dibujaEtiqueta("article", array("style" => "background-image: url($foto)", "id" => "principal"), null, false) . PHP_EOL;

    echo CHTML::dibujaEtiqueta("div", array("id" => "dPlaneta"), null, false) . PHP_EOL;
    echo CHTML::dibujaEtiqueta("h2", [], $planeta->nombre) . PHP_EOL;
    echo CHTML::dibujaEtiqueta("h6", [], $planeta->descripcion) . PHP_EOL;
    echo CHTML::dibujaEtiqueta("h6", [], "Clima: " . $planeta->clima) . PHP_EOL;
    echo CHTML::dibujaEtiqueta("h6", [], "Tiempo de viaje: " . $planeta->duracion_viaje . " horas.") . PHP_EOL;
    echo CHTML::dibujaEtiquetaCierre("div") . PHP_EOL;

    echo CHTML::dibujaEtiquetaCierre("article") . PHP_EOL;

    echo CHTML::dibujaEtiqueta("div", array("id" => "filtro"), null, false) . PHP_EOL;

    echo CHTML::dibujaEtiquetaCierre("div") . PHP_EOL;

    echo CHTML::dibujaEtiqueta("article", array("id" => "billetes"), null, false) . PHP_EOL;

    //Se dibujan los billetes 1 a 1 
    foreach ($vuelos as $ind => $val)
        echo $this->dibujaVistaParcial("billetePaginado", array("vuelo" => $val), true) . PHP_EOL;

    echo CHTML::dibujaEtiquetaCierre("article") . PHP_EOL;
    ?>

    <nav aria-label="Page navigation example" id="paginado">
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#">Anterior</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">Siguiente</a></li>
        </ul>
    </nav>
</section>