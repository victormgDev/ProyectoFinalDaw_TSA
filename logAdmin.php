<?php
session_start();
session_unset();
session_destroy();
include 'templates/head.php';
include 'modeloControlador/controladorAdmin.php';
?>

<!DOCTYPE html>
<html lang="es" data-bs-theme="light" id="html" >
<head>
  <meta charset="UTF-8">
  <title>Todo sobre aviones</title>
  <link rel="stylesheet"href="css/styles.css">
  <link rel="stylesheet"href="node_modules/bootstrap-icons/font/bootstrap-icons.css">

</head>
<body>
<div class="container-fluid" id="inicioAdmin" aria-label="Pagina De Inicio Admin">
  <h1 class="text-center animate__animated animate__flip ">Iniciar Sesión como Administrador</h1>
  <div class="row justify-content-center">
    <div id="alertloginAdmin"></div>
    <div class="form-floating col-9 col-sm-8 col-md-7 col-lg-6">
      <form id="formLoginAdmin" method="POST"  aria-label="Formulario para Iniciar Sesion como Admin">
        <div class="form-floating mb-3">
          <input type="email" class="form-control" id="emailAdmin" name="emailAdmin" placeholder="Email"required >
          <label for="emailAdmin" class="form-label">Email</label>
        </div>
        <div class="form-floating mb-3">
          <input type="password" class="form-control" id="passwordAdmin" name="passwordAdmin" placeholder="Contraseña" required>
          <label for="passwordAdmin" class="form-label">Contraseña</label>
        </div>
        <button type="submit" class="btn btn-outline-primary" onclick="iniciarSesionAdmin(event)">Iniciar Sesion</button>
      </form>
      <div id="divCambiarPasword" class="form-floating col-9 col-sm-8 col-md-7 col-lg-6"></div>
      <div id="alertCambiarPassword" class="text-center"></div>
    </div>
  </div>
</div>
<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
<script src="js/app.js"></script>
</body>
<footer>
  <?php include 'templates/footer.php'; ?>
</footer>
</html>

