<?php 

$this->textoHead = "<style>
@media (max-width:460px){    
    table > thead > tr > th:nth-child(3),
    table > tbody > tr > td:nth-child(3){
        display: none;

    table > thead > tr > th:nth-child(2),
    table > tbody > tr > td:nth-child(2){
        display: none;
    }
  }
</style>";

$this->lang = $_COOKIE["lang"];

?>

<div style="min-height: 500px;" class="p-1">
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col"><?php echo $palabras[0]; ?></th>
      <th scope="col"><?php echo $palabras[1]; ?></th>
      <th scope="col"><?php echo $palabras[2]; ?></th>
      <th scope="col"><?php echo $palabras[3]; ?></th>
      <th scope="col"><?php echo $palabras[4]; ?></th>
    </tr>
  </thead>
  <tbody>

  <?php
    foreach ($billetes as $clave => $datos) {

    //Se crea una ventana modal correspondiente al boton anular de cada billete
    $ventana = new CModal(  "billete" . $datos[2],
                            $palabras[5],
                            "{$palabras[6]}<b>{$datos[1]}</b><br>{$palabras[7]}<b>{$datos[3]}</b><br>
                             {$palabras[8]}",
                            Sistema::app()->generaURL(array("Compra", "Anular"), array("codigo" => $datos[2])));

    $ventana->dibujate();
    
    //Se guardan en contenido los enlaces a descargar y anular
    $contenido = CHTML::link(CHTML::imagen("../../../imagenes/iconos/descarga.png"),
                              $url."?codigo={$datos[2]}",
                              array("class" => "btn btn-info"));


    if ($op =="1"){
        $contenido .= CHTML::botonHtml( CHTML::imagen("../../../imagenes/iconos/borrar_vuelo.png"),
        array(
            "class" => "btn btn-danger",
            "data-bs-toggle" => "modal",
            "data-bs-target" => "#billete{$datos[2]}"));
      }


      echo CHTML::dibujaEtiqueta("tr",[],null,false).PHP_EOL;

      echo CHTML::dibujaEtiqueta("td",[],CGeneral::fechaMysqlANormal($datos[3])).PHP_EOL;
      echo CHTML::dibujaEtiqueta("td",[],$datos[4]).PHP_EOL;
      echo CHTML::dibujaEtiqueta("td",[],$datos[0]).PHP_EOL;
      echo CHTML::dibujaEtiqueta("td",[],$datos[1]).PHP_EOL;
      echo CHTML::dibujaEtiqueta("td",[],$contenido).PHP_EOL;

      echo CHTML::dibujaEtiquetaCierre("tr").PHP_EOL;
    }
  ?>
  </tbody>
</table>
</div>