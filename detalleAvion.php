
<?php
include 'modeloControlador/controlador.php';
include 'templates/head.php';
?>
<script src="https://cdn.jsdelivr.net/npm/bad-words"></script>
<div class="container-fluid mt-5" aria-label="Detalles de Avion">
  <div id="alertDetalleAvion" aria-label="Alertas para el detalle del avion"></div>
  <div class="row justify-content-center">
    <div class="col-10">
      <?php detalleAvion(); ?>
    </div>
  </div>
</div>
<?php
include 'templates/footer.php';
?>
