<?php
  $this->textoHead = "<link rel='stylesheet' href='/estilos/destinos.css'>";
?>

<main id="destinos">
    <section id="planetas">
    <?php
        foreach ($planetas as $clave => $planeta){
            $url = Sistema::app()->generaURL(["inicial","infoDestino"])."?codigo=".$planeta["cod_destino"];
            echo $this->dibujaVistaParcial("destinoPaginado",array("planeta"=>$planeta,"datos"=>$url),true).PHP_EOL;  
        }   
    ?>
    </section>
</main>