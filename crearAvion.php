<?php
include "templates/head.php"; //cabecera de la pagina
include "modeloControlador/controlador.php"; //incluimos el modelo para poder crear la conexion a la BD

?>

<div class="container-fluid" aria-label="Formulario para crear Avion">
  <div class="row justify-content-center">

    <div class="col col-9">
      <div id="alertCrearAvion">  </div>
      <form method="post" id="formCrearAvion" class="form-control" enctype="multipart/form-data"> <!-- enctype="multipart/form-data" para permitir la subida de archivos -->
        <h3 class="text-center mb-3">Crear Avion</h3>
        <label for="fabricante" id="fabricante" class="form-label">Fabricante</label>
        <input type="text" id="fabricante" name="fabricante" class="form-control mb-3" required>

        <label for="modelo" id="modelo" class="form-label">Modelo</label>
        <input type="text" id="modelo" name="modelo" class="form-control mb-3" required>

        <label for="capacidad" id="capacidad" class="form-label">Capacidad</label>
        <input type="text" id="capacidad" name="capacidad" class="form-control mb-3" required>

        <label for="velMax" id="velMax" class="form-label">Velocidad Maxima</label>
        <input type="text" id="velMax" name="velMax" class="form-control mb-3" required>

        <label for="autonomia" id="autonomia" class="form-label">Autonomia</label>
        <input type="text" id="autonomia" name="autonomia" class="form-control mb-3" required>

        <label for="descripcion" id="descripcion" class="form-label">Descripcion</label>
        <textarea id="descripcion" name="descripcion" class="form-control mb-3" rows="5" required></textarea>

        <label for="imagen" id="imagen" class="form-label">Imagen</label>
        <input type="file" class="form-control" id="imagen" name="imagen" required>
        <button type="submit" class="btn btn-outline-primary w-25 mt-3 mx-auto d-block" onclick="crearAvion()">Crear</button>
      </form>
    </div>
  </div>

</div>
<?php include 'templates/footer.php'; ?>
