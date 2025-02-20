<?php
$this->textoHead = '<link rel="stylesheet" href="/estilos/destinos.css">';
$this->lang = $palabras[0];

    echo CHTML::dibujaEtiqueta("section",["id"=>"planeta"],null,false).PHP_EOL;
    
    echo CHTML::dibujaEtiqueta("article", array("style" => "background-image: url({$planeta[5]})", "id" => "principal"), null, false) . PHP_EOL;

    echo CHTML::dibujaEtiqueta("div", array("id" => "dPlaneta"), null, false) . PHP_EOL;
        echo CHTML::dibujaEtiqueta("h2", [], $planeta[1]) . PHP_EOL;
        echo CHTML::dibujaEtiqueta("h6", [], $planeta[2]) . PHP_EOL;
        echo CHTML::dibujaEtiqueta("h6", [], $palabras[1] . $planeta[3]) . PHP_EOL;
        echo CHTML::dibujaEtiqueta("h6", [], $palabras[2] . $planeta[4] .$palabras[3]) . PHP_EOL;
    echo CHTML::dibujaEtiquetaCierre("div") . PHP_EOL;

    echo CHTML::dibujaEtiquetaCierre("article") . PHP_EOL;

    echo CHTML::dibujaEtiqueta("article",["id"=>"filtroMob"],CHTML::botonHtml("",["class"=>"miBoton","id"=>"btnFiltro"])).PHP_EOL;

    //Sino hay vuelos con los criterios seleccionados, se muestra un mensaje
    if (empty($vuelos))
        echo CHTML::dibujaEtiqueta("article",array("id"=>"noResul"),CHTML::dibujaEtiqueta("h3",[],$err[1])).PHP_EOL;
    
    //Sino se dibujan los billetes 1 a 1 
    else{

        echo CHTML::dibujaEtiqueta("article", array("id" => "billetes"), null, false) . PHP_EOL;

        foreach ($vuelos as $ind => $val){
            $url = Sistema::app()->generaURL(["compra","Compra"])."?codigo=".$val["cod_vuelo"];
            echo $this->dibujaVistaParcial("billetePaginado", array("vuelo" => $val,"enlace"=>$url,"palabras"=>$palabras), true) . PHP_EOL;
        } 
    
        echo CHTML::dibujaEtiquetaCierre("article") . PHP_EOL;
    }

    echo CHTML::dibujaEtiqueta("article",["id"=>"banners"],null,false).PHP_EOL;
        echo CHTML::dibujaEtiqueta("section",["class"=>"banner","style"=>"background-image: url('/imagenes/banners/curiosity-ban.jpeg')"],null,false).PHP_EOL;
            echo CHTML::dibujaEtiqueta("div",["class"=>"datosBanner"],"Prueba de banner").PHP_EOL;
        echo CHTML::dibujaEtiquetaCierre("section").PHP_EOL;

        echo CHTML::dibujaEtiqueta("section",["class"=>"banner","style"=>"background-image: url('/imagenes/banners/ia-ban.jpg')"],null,false).PHP_EOL;
            echo CHTML::dibujaEtiqueta("div",["class"=>"datosBanner"],"Prueba de banner").PHP_EOL;
        echo CHTML::dibujaEtiquetaCierre("section").PHP_EOL;
    echo CHTML::dibujaEtiquetaCierre("article").PHP_EOL;

    echo CHTML::dibujaEtiqueta("nav",["aria-label"=>"Page navigation example", "id"=>"paginado"],null,false).PHP_EOL;
        echo CHTML::dibujaEtiqueta("ul",["class"=>"pagination"],null,false).PHP_EOL;

        for ($cont=1; $cont < ceil(count($vuelos)/7)+1 ; $cont++){

            $url = Sistema::app()->generaURL(["inicial","infoDestino"])."?codigo=".$planeta[0]."&pag=".$cont;

             echo CHTML::dibujaEtiqueta("li",["class"=>"page-item"],
                    CHTML::dibujaEtiqueta("a",["class"=>"page-link", 
                                                "href"=>$url],
                                                $cont)).PHP_EOL;
            }
        echo CHTML::dibujaEtiquetaCierre("ul").PHP_EOL;
    echo CHTML::dibujaEtiquetaCierre("nav").PHP_EOL;

    echo CHTML::dibujaEtiquetaCierre("section").PHP_EOL;

    echo CHTML::dibujaEtiqueta("article",array("id" => "filtro"),null,false).PHP_EOL;

    echo CHTML::iniciarForm("","get"). PHP_EOL;

    echo CHTML::dibujaEtiqueta("div",[],null,false).PHP_EOL;
            echo CHTML::campoLabel($palabras[5],"compannia").PHP_EOL;
            echo CHTML::dibujaEtiqueta("br").PHP_EOL;
            echo CHTML::campoText("compannia",$datos["comp"]).PHP_EOL;
    echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;

    echo CHTML::dibujaEtiqueta("div",[],null,false).PHP_EOL;
            echo CHTML::campoLabel($palabras[6],"fecha").PHP_EOL;
            echo CHTML::dibujaEtiqueta("br").PHP_EOL;
            echo CHTML::campoDate("fecha",$datos["fech"]).PHP_EOL;
    echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;

    echo CHTML::dibujaEtiqueta("div",[],null,false).PHP_EOL;
            echo CHTML::campoLabel($palabras[8],"fecha_llegada").PHP_EOL;
            echo CHTML::dibujaEtiqueta("br").PHP_EOL;
            echo CHTML::campoDate("fecha_llegada",$datos["lleg"]).PHP_EOL;
    echo CHTML::dibujaEtiquetaCierre("div").PHP_EOL;

    echo CHTML::campoHidden("planeta",$planeta[1]).PHP_EOL;

    echo CHTML::campoBotonSubmit($palabras[4],array("class"=>"btn btn-dark w-50")).PHP_EOL;

    echo CHTML::finalizarForm();

    echo CHTML::dibujaEtiquetaCierre("article") . PHP_EOL;
