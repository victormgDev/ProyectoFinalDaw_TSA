<?php
include 'templates/head.php';
include 'modeloControlador/controlador.php';
?>

<div class="container-fluid" aria-label="Formulario para crear Avion">
  <div class="row justify-content-center">
    <div class="col col-9">
      <div id="alertCrearAvion"> </div>
      <form method="post" id="formCrearAvion" class="form-control" enctype="multipart/form-data"> <!-- enctype="multipart/form-data" para permitir la subida de archivos -->
        <h3 class="text-center mb-3">Crear Avion</h3>
        <label for="fabricante" id="fabricante" class="form-label">Fabricante</label>
        <input type="text" id="fabricante" name="fabricante" class="form-control mb-3" required>

        <label for="modelo" id="modelo" class="form-label">Modelo</label>
        <input type="text" id="modelo" name="modelo" class="form-control mb-3" required>

        <label for="imagen" id="imagen" class="form-label">Imagen</label>
        <input type="file" class="form-control" id="imagen" name="imagen" required>
        <button type="button" class="btn btn-outline-primary w-25 mt-3 mx-auto d-block" onclick="buscarDescripcion()">Buscar Descripcion</button>
        <div id="descripcionAvion" class="mt-3"></div>
        <button type="submit" class="btn btn-outline-primary w-25 mt-3 mx-auto d-block" onclick="crearAvion()">Crear</button>
      </form>
    </div>
  </div>

</div>
<footer>
  <?php include 'templates/footer.php'; ?>
</footer>

