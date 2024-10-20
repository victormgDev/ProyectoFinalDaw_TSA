<?php
include 'modeloControlador/controlador.php';
include 'templates/head.php';
?>
<div class="container-fluid" id="containerRegistro">
  <div class="row justify-content-center" id="alertRegistro"></div>
  <h3 class="text-center">Registrate</h3>
  <div class="row justify-content-center">
    <div class="form-floating col-9 col-sm-8 col-md-7 col-lg-6">
      <form id="registroForm" method="post">
        <input type="hidden" name="formulario" value="registro">
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" required>
          <label for="usuario" class="form-label">Usuario</label>
        </div>
        <div class="form-floating mb-3">
          <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
          <label for="email" class="form-label">Email</label>
        </div>
        <div class="form-floating mb-3">
          <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
          <label for="password" class="form-label">Contraseña</label>
        </div>
        <button type="submit" class="btn btn-outline-primary w-100" onclick="registrarUsuario()">Registrarse</button>
      </form>
      <div class="text-center mt-3">
        <a href="login.php" class="btn btn-outline-primary w-100">Iniciar Sesion</a>
      </div>
      <div class="text-center mt-3">
        <a href="index.php" class="btn btn-outline-primary w-100">Volver</a>
      </div>
    </div>
  </div>
</div>
<?php include 'templates/footer.php'; ?>

