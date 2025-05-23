<?php
include 'templates/head.php';
include 'modeloControlador/controlador.php';
?>
<script src="js/app.js"></script>
<?php
if ($idUsuario = existeUsuario()){
    echo '
    <div class="container-fluid " aria-label="Contenedor del formulario para crear Avion">
  <div class="row justify-content-center">
    <div class="col col-9">
      <form method="post" id="formCrearAvion" class="form-control" enctype="multipart/form-data" aria-label="Formulario para crear avion"> <!-- enctype="multipart/form-data" para permitir la subida de archivos -->
        <h3 class="text-center mb-3">Crear Avion</h3>
        <label for="fabricante"  class="form-label">Fabricante</label>
        <input type="text" id="fabricante" name="fabricante" class="form-control mb-3" required aria-label="Introduce el fabricante">

        <label for="modelo" class="form-label">Modelo</label>
        <input type="text" id="modelo" name="modelo" class="form-control mb-3" required aria-label="Introduce el modelo">

        <label for="imagen" id="imagen" class="form-label">Imagen</label>
        <input type="file" class="form-control" id="imagen" name="imagen" required aria-label="Inserte una imagen">
        <button type="button" class="btn btn-outline-primary w-50 mt-3 mx-auto d-block" onclick="buscarDescripcion()" aria-label="Boton para la descripcion">Buscar Descripcion</button>
        <div id="divDescripcionAvion" class="mt-3"></div>
        <button type="submit" class="btn btn-outline-primary w-50 mt-3 mx-auto d-block" onclick="crearAvionBusqueda()" aria-label="Boton para crear el avion">Crear</button>
      </form>
      <div id="alertCrearAvion" aria-label="Alertas para informacion sobre crear el avion"> </div>
    </div>
  </div>
</div>';
} else{
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Tienes que iniciar sesion</div>';
}
?>

<footer>
  <?php include 'templates/footer.php'; ?>
</footer>

