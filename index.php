<?php
include 'modeloControlador/controlador.php';
include 'templates/head.php';
?>

<div class="container-fluid" id="noticias" aria-label="Ultimas noticias">
  <div class="row justify-content-center">
    <?php //llamamos a la funcion de controlador.php para mostrar las noticias
    $rss = 'https://news.google.com/rss/search?q=aviones&hl=es&gl=ES&ceid=ES:es';
    mostrarNoticias($rss);
    ?>
  </div>
    <?php include 'templates/footer.php'; ?>
</div>



