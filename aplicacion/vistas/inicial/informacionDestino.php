<?php
$this->textoHead = '<link rel="stylesheet" href="/estilos/destinos.css">';
$this->lang = $palabras[0];
?>

<section id="planeta">

    <?php
    echo CHTML::dibujaEtiqueta("article", array("style" => "background-image: url({$planeta[5]})", "id" => "principal"), null, false) . PHP_EOL;

    echo CHTML::dibujaEtiqueta("div", array("id" => "dPlaneta"), null, false) . PHP_EOL;
    echo CHTML::dibujaEtiqueta("h2", [], $planeta[1]) . PHP_EOL;
    echo CHTML::dibujaEtiqueta("h6", [], $planeta[2]) . PHP_EOL;
    echo CHTML::dibujaEtiqueta("h6", [], $palabras[1] . $planeta[3]) . PHP_EOL;
    echo CHTML::dibujaEtiqueta("h6", [], $palabras[2] . $planeta[4] .$palabras[3]) . PHP_EOL;
    echo CHTML::dibujaEtiquetaCierre("div") . PHP_EOL;

    echo CHTML::dibujaEtiquetaCierre("article") . PHP_EOL;

    echo CHTML::dibujaEtiqueta("div", array("id" => "filtro"), null, false) . PHP_EOL;

    echo CHTML::iniciarForm();

    echo CHTML::campoText("compannia","",["placeholder"=>$palabras[5]]).PHP_EOL;
    echo CHTML::campoDate("fecha").PHP_EOL;
    echo CHTML::campoHidden("codigo",$planeta[0]).PHP_EOL;
    echo CHTML::campoBotonSubmit($palabras[4],array("class"=>"btn btn-dark")).PHP_EOL;

    echo CHTML::finalizarForm();

    echo CHTML::dibujaEtiquetaCierre("div") . PHP_EOL;

    echo CHTML::dibujaEtiqueta("article", array("id" => "billetes"), null, false) . PHP_EOL;

    //Se dibujan los billetes 1 a 1 
    foreach ($vuelos as $ind => $val){
        $url = Sistema::app()->generaURL(["compra","Compra"])."?codigo=".$val["cod_vuelo"];
        echo $this->dibujaVistaParcial("billetePaginado", array("vuelo" => $val,"enlace"=>$url,"palabras"=>$palabras), true) . PHP_EOL;
    } 

    echo CHTML::dibujaEtiquetaCierre("article") . PHP_EOL;
    ?>

    <nav aria-label="Page navigation example" id="paginado">
        <ul class="pagination">
        <?php
            for ($cont=1; $cont < ceil(count($vuelos)/7)+1 ; $cont++){

                $url = Sistema::app()->generaURL(["inicial","infoDestino"])."?codigo=".$planeta[0]."&pag=".$cont;

                echo CHTML::dibujaEtiqueta("li",["class"=>"page-item"],
                        CHTML::dibujaEtiqueta("a",["class"=>"page-link", 
                                                    "href"=>$url],
                                                    $cont)).PHP_EOL;
            }
        ?>
        </ul>
    </nav>
</section>