<?php
  $this->textoHead = "<link rel='stylesheet' href='/estilos/destinos.css'>";
  $this->lang = $palabras[0];
?>

<main id="destinos">
    <section>
    <?php
        foreach ($planetas as $clave => $planeta){
            $url = Sistema::app()->generaURL(["inicial","infoDestino"])."?codigo=".$planeta["cod_destino"];
            echo $this->dibujaVistaParcial("destinoPaginado",array("planeta"=>$planeta,"datos"=>$url,"palabras"=>$palabras),true).PHP_EOL;  
        }   
    ?>
    </section>
</main>