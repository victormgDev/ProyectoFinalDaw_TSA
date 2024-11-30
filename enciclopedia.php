<?php
require 'modeloControlador/controlador.php';
include 'templates/head.php';
?>

<div class="container-fluid mt-5" aria-label="Contenedor de enciclopedia">
  <h3 class="text-center">Enciclopedia</h3>

  <div class="row justify-content-center">
    <div class="col12">
      <?php
      //Si el usuario a iniciado sesion aparecera un boton para poder añadir mas aviones
      if (isset($_SESSION['usuario'])|| isset($_SESSION['admin'])) {
        echo "<a href='avion.php' class='btn btn-outline-primary mb-3' aria-label='Boton añadir avion'>Añadir Avion</a>";
      }
      ?>
      <form id="formBusquedaAviones" method="post" class="d-flex" aria-label="Formulario para filtrar aviones">
        <input class="form-control me-2" type="search" name="consulta" placeholder="Buscar Aviones" aria-label="Buscar Aviones">
        <select class="form-select me-2" name="orden" aria-label="Filtro por Caracteristicas">
          <option selected>Filtar Busqueda</option>
          <option value="fabricante">Fabricante</option>
          <option value="velocidad_maxima">Velocidad Maxima</option>
          <option value="capacidad">Capacidad</option>
        </select>
        <select class="form-select me-2" name="direccion" aria-label="Direccion de Busqueda">
          <option value="ASC">Ascendente</option>
          <option value="DESC">Descendente</option>
        </select>
        <button class="btn btn-outline-primary" type="button" id="filtrarAviones" onclick="mostrarAviones()" aria-label="Boton para buscar avion">Buscar</button>
      </form>
    </div>
  </div>
</div>

<div class="container-fluid mt-3" id="resultados" aria-label="Contenedor de resultados de busqueda">
</div>

<?php include 'templates/footer.php'; ?>


