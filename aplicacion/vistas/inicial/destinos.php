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

      <nav aria-label="Page navigation example">
        <ul class="pagination">
          <li class="page-item"><a class="page-link" href="#">Anterior</a></li>
          <li class="page-item"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item"><a class="page-link" href="#">Siguiente</a></li>
        </ul>
      </nav>
    </section>
</main>