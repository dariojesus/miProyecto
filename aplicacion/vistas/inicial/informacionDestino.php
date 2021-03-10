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

    echo CHTML::iniciarForm();

    echo CHTML::campoText("compannia","",["placeholder"=>"Compañia"]).PHP_EOL;
    echo CHTML::campoDate("fecha").PHP_EOL;
    echo CHTML::campoHidden("codigo",$planeta->cod_destino).PHP_EOL;
    echo CHTML::campoBotonSubmit("Filtrar",array("class"=>"btn btn-dark")).PHP_EOL;

    echo CHTML::finalizarForm();

    echo CHTML::dibujaEtiquetaCierre("div") . PHP_EOL;

    echo CHTML::dibujaEtiqueta("article", array("id" => "billetes"), null, false) . PHP_EOL;

    //Se dibujan los billetes 1 a 1 
    foreach ($vuelos as $ind => $val){
        $url = Sistema::app()->generaURL(["compra","Compra"])."?codigo=".$val["cod_vuelo"];
        echo $this->dibujaVistaParcial("billetePaginado", array("vuelo" => $val,"enlace"=>$url), true) . PHP_EOL;
    } 

    echo CHTML::dibujaEtiquetaCierre("article") . PHP_EOL;
    ?>

    <nav aria-label="Page navigation example" id="paginado">
        <ul class="pagination">
        <?php
            for ($cont=1; $cont < ceil(count($vuelos)/7)+1 ; $cont++){

                $url = Sistema::app()->generaURL(["inicial","infoDestino"])."?codigo=".$planeta->cod_destino."&pag=".$cont;

                echo CHTML::dibujaEtiqueta("li",["class"=>"page-item"],
                        CHTML::dibujaEtiqueta("a",["class"=>"page-link", 
                                                    "href"=>$url],
                                                    $cont)).PHP_EOL;
            }
        ?>
        </ul>
    </nav>
</section>