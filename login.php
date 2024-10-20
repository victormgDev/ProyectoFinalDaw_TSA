<?php
include 'modeloControlador/controlador.php';
include 'templates/head.php';
?>
<div class="container mt-5" aria-label="Contenedor principal de Login">
  <h1 class="text-center animate__animated animate__flip ">Iniciar Sesión</h1>
  <div class="row justify-content-center" aria-label="Fila del formulario">
    <div id="alertFormIniciarSesion" class="row justify-content-center" aria-label="Div para alertas"></div>
    <div class="form-floating col-9 col-sm-8 col-md-7 col-lg-6">
      <form id="formIniciarSesion" method="POST" aria-label="Formulario iniciar Sesion">
        <div class="form-floating mb-3">
          <input type="email" class="form-control " id="email" name="email" placeholder="Usuario@ejemplo.com" required>
          <label for="email" class="form-label" >Usuario</label>
        </div>
        <div class="form-floating mb-3">
          <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
          <label for="password" class="form-label">Contraseña</label>
        </div>
        <button type="submit" class="btn btn-outline-primary w-100" onclick="iniciarSesion()">Iniciar Sesión</button>
      </form>
      <div class="text-center mt-3">
        <a href="/appTsa/registrar.php" class="btn btn-secondary w-100">Registrarse</a>
      </div>
    </div>
  </div>
  <script src="/appTsa/node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
</div>


<?php include 'templates/footer.php'; ?>
