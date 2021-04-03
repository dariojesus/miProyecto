<?php
  $this->textoHead = "<link rel='stylesheet' href='/estilos/destinos.css'>";
  $this->lang = $lang;

  switch($lang){

    case("en"): $arr = ["Trip duration: "," hours"];break;
    default: $arr = ["Duración del viaje: "," horas"];break;
  }
?>

<main id="destinos">
    <section>
    <?php
        foreach ($planetas as $clave => $planeta){
            $url = Sistema::app()->generaURL(["inicial","infoDestino"])."?codigo=".$planeta["cod_destino"];
            echo $this->dibujaVistaParcial("destinoPaginado",array("planeta"=>$planeta,"datos"=>$url,"arr"=>$arr),true).PHP_EOL;  
        }   
    ?>
    </section>
</main>