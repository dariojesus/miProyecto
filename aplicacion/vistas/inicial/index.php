<?php
$this->textoHead = "<script src='/javascript/peticiones.js' defer></script>";
$this->lang = $palabras[0];
?>

<main>
  <header id="cabecera">
    <div class="principal">
      <form method="POST">
        <input list="listaPlanetas" id="busqueda" class="buscar" placeholder= "<?php echo $palabras[2] ?>" >
        <button type="submit" class="miBoton">Buscar</button>
        <datalist id="listaPlanetas"></datalist>
        <p id="titulo">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Numquam ut non officiis </p>
      </form>
    </div>
  </header>
  <section id="seccion1">
    <h2><?php echo $palabras[1] ?></h2>
  </section>
</main>