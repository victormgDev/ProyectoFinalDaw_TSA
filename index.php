<?php include 'templates/head.php';
include 'modeloControlador/controlador.php';
?>
<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Todo sobre aviones</title>
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="node_modules/bootstrap-icons/font/bootstrap-icons.css">
  <meta name="description" content="">

  <meta property="og:title" content="">
  <meta property="og:type" content="">
  <meta property="og:url" content="">
  <meta property="og:image" content="">
  <meta property="og:image:alt" content="">

  <link rel="manifest" href="site.webmanifest">
  <meta name="theme-color" content="#fafafa">
</head>

<body>
<div class="container-fluid" id="noticias" aria-label="Ultimas noticias">
  <div class="row justify-content-center">

    <?php //llamamos a la funcion de controlador.php para mostrar las noticias
    $rss = 'https://news.google.com/rss/search?q=aviones&hl=es&gl=ES&ceid=ES:es';
    mostrarNoticias($rss);
    ?>
  </div>
</div>
<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
</body>
<footer>
  <?php include 'templates/footer.php'; ?>
</footer>
</html>
