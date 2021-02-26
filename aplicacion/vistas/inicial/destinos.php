<?php
  $this->textoHead = "<link rel='stylesheet' href='/estilos/destinos.css'>";
?>

<div id="filtro"></div>

<main id="destinos">
    <section id="planetas">

    <?php
        foreach ($planetas as $clave => $planeta)
                echo $this->dibujaVistaParcial("destinoPaginado",array("planeta"=>$planeta),true).PHP_EOL;  
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