<?php
$this->textoHead = "<script src='/javascript/peticiones.js' defer></script>";
$this->lang = $palabras[0];
?>

<main>
  <header id="cabecera">
    <div class="principal">
      <input type="text" id="busqueda" class="buscar" placeholder= "<?php echo $palabras[3] ?>" >
      <p id="titulo">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Numquam ut non officiis </p>
    </div>
  </header>
  <section id="ultimoViaje">
    <h2><b><?php echo $palabras[1] ?></b></h2>
  </section>
  <section id="seccion1">
    <h2><?php echo $palabras[2] ?></h2>
  </section>
</main>