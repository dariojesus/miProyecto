<?php $this->textoHead = "<style>
@media (max-width:400px){    
    table > thead > tr > th:nth-child(3),
    table > tbody > tr > td:nth-child(3){
        display: none;
    }
  }
</style>"?>

<div style="min-height: 500px;" class="p-1">
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Fecha</th>
      <th scope="col">Hora</th>
      <th scope="col">Clase</th>
      <th scope="col">Destino</th>
      <th scope="col">Billete</th>
    </tr>
  </thead>
  <tbody>

  <?php
    foreach ($billetes as $clave => $datos) {
      echo CHTML::dibujaEtiqueta("tr",[],null,false).PHP_EOL;

      echo CHTML::dibujaEtiqueta("td",[],CGeneral::fechaMysqlANormal($datos["fecha_salida"])).PHP_EOL;
      echo CHTML::dibujaEtiqueta("td",[],$datos["hora_salida"]).PHP_EOL;
      echo CHTML::dibujaEtiqueta("td",[],$datos["clase"]).PHP_EOL;
      echo CHTML::dibujaEtiqueta("td",[],$datos["destino"]).PHP_EOL;
      echo CHTML::dibujaEtiqueta("td",[],CHTML::link(CHTML::imagen("../../../imagenes/iconos/descarga.png"),$url."?codigo={$datos['codigo']}")).PHP_EOL;

      echo CHTML::dibujaEtiquetaCierre("tr").PHP_EOL;
    }
  ?>
  </tbody>
</table>
</div>