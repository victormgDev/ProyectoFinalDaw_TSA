<?php
include 'modeloControlador/controlador.php';
include 'templates/head.php';
$conn = crearConexion();

?>
<div class="container-fluid mt-5" aria-label="Detalles de Avion">
  <div id="alertDetalleAvion"></div>
  <div class="row justify-content-center">
    <div class="col-10">
      <?php detalleAvion(); ?>
    </div>
  </div>
</div>
<script src="/appTsa/node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
<?php
include 'templates/footer.php';
?>
