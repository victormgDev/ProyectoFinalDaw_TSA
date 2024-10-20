<?php
require 'modeloControlador/controlador.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Title</title>
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
  <script src="node_modules/jquery/dist/jquery.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</head>
<body>
<?php include 'templates/head.php'; ?>

<div class="container-fluid mt-5">
  <h3 class="text-center">Enciclopedia</h3>

  <div class="row justify-content-center">
    <div class="col12">
      <?php
      //Si el usuario a iniciado sesion aparecera un boton para poder añadir mas aviones
      if (isset($_SESSION['usuario'])) {
        echo "<a href='crearAvion.php' class='btn btn-outline-primary mb-3'>Añadir Avion</a>";
      }
      ?>
      <form id="formBusquedaAviones" method="post" class="d-flex">
        <input class="form-control me-2" type="search" name="consulta" placeholder="Buscar Aviones" aria-label="Buscar Aviones">
        <select class="form-select me-2" name="orden" aria-label="Filtro por Caracteristicas">
          <option selected>Filtar Busqueda</option>
          <option value="fabricante">Fabricante</option>
          <option value="velocidad_maxima">Velocidad Maxima</option>
          <option value="capacidad">Capacidad</option>
        </select>
        <select class="form-select me-2" name="direccion"aria-label="Direccion de Busqueda">
          <option value="ASC">Ascendente</option>
          <option value="DESC">Descendente</option>
        </select>
        <button class="btn btn-outline-primary" type="button" id="filtrarAviones" onclick="mostrarAviones()">Buscar</button>
      </form>
    </div>
  </div>
</div>

<div class="container-fluid mt-3" id="resultados">
</div>

<?php include 'templates/footer.php'; ?>

<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
</body>
</html>
