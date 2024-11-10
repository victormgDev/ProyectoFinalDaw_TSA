<?php
include 'modeloControlador/controlador.php';
include 'templates/head.php';
?>

<div class="container-fluid" id="containerRegistro">
  <div class="row justify-content-center" id="alertRegistro"></div>
  <h3 class="text-center">Registrate</h3>
  <div class="row justify-content-center">
    <div class="form-floating col-9 col-sm-8 col-md-7 col-lg-6">
      <form id="registroForm" method="post" class="needs-validation" novalidate>
        <input type="hidden" name="formulario" value="registro">
        <div class="form-floating mb-3">
          <input type="text" class="form-control" id="usuarioRegistro" name="usuarioRegistro" placeholder="Usuario" required>
          <label for="usuarioRegistro" class="form-label">Usuario</label>
            <div class="invalid-feedback">
                El usuario debe de empezar por minimo 4 letras y le puede seguir un numero
            </div>
        </div>
        <div class="form-floating mb-3">
          <input type="email" class="form-control" id="emailRegistro" name="emailRegistro" placeholder="Email" required>
          <label for="emailRegistro" class="form-label">Email</label>
            <div class="invalid-feedback">
                El email debe comenzar por letra minuscula seguido de @ .com , .es o .org
            </div>
        </div>
        <div class="form-floating mb-3">
          <input type="password" class="form-control" id="passwordRegistro" name="passwordRegistro" placeholder="Contraseña" required>
          <label for="passwordRegistro" class="form-label">Contraseña</label>
            <div class="invalid-feedback">
                La contraseña debe tener al menos 6 caracteres, incluyendo letras o números.
            </div>
        </div>
        <button id="btnRegistro" type="submit" class="btn btn-outline-primary w-100" onclick="registrarUsuario()">Registrarse</button>
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
<script src="/appTsa/js/app.js"></script>
<?php include 'templates/footer.php'; ?>

