<?php
$this->textoHead = "<script src='/javascript/peticiones.js' defer></script>";
$this->lang = $palabras[0];
?>

<main>
  <header id="cabecera">
    <div class="principal">
      <form method="POST">
        <div>
          <input list="listaPlanetas" id="busqueda" name="buscar" class="buscar" placeholder= "<?php echo $palabras[2] ?>" >
          <button type="submit" class="miBoton"></button>
        </div>
        <datalist id="listaPlanetas"></datalist>
        <p id="titulo">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Numquam ut non officiis </p>
      </form>
    </div>
  </header>
  <section id="seccion1">
    <h2><?php echo $palabras[1] ?></h2>
  </section>
</main>