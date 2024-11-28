<?php
include 'modeloControlador/controladorAdmin.php';
include 'templates/head.php';
?>

<div class="container-fluid mt5">
  <h3 class="text-center"> Mi Cuenta</h3>
  <div class="row justify-content-center" aria-label="Div para datos de Cuenta">
    <div class="col-9 justify-content-start mb-3 border border-3 rounded-3">
      <?php $idAdmin = $_SESSION['idAdmin'];
      mostrarDatosAdmin($idAdmin); //funcion para mostrar los datos de la cuenta ?>
    </div>
  </div>
  <div class="row justify-content-center" aria-label="Div para el formulario de modificacion de cuenta">
    <div class="col-9 justify-content-center  mb-3 border border-3 rounded-3">
      <div id="alertFormMiCuentaAdmin" aria-label="Div para alertas en la modificacion"></div>
      <div class="form-floating col">
        <h3 class="text-center mt-2">Editar Datos</h3>
        <form id="formEditarMiCuentaAdmin" class="needs-validation" novalidate aria-label="Formulario editar Cuenta Admin" method="POST" onsubmit="editarMiCuentaAdmin(<?php echo $_SESSION['idAdmin']; ?>); return false;" >
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Nombre de usuario" required>
            <label for="usuario" class="form-label">Nombre</label>
              <div class="invalid-feedback" aria-label="Condiciones de Usuario Admin">
                  El usuario administrador debe de empezar por minimo 4 letras y le puede seguir un numero
              </div>
          </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control " id="email" name="email" placeholder="Usuario@tsa.com" required>
                <label for="email" class="form-label" >Usuario@tsa.com</label>
                <div class="invalid-feedback" aria-label="Condiciones Email Admin">
                    El email debe comenzar por letra minuscula seguido de @tsa.com
                </div>
            </div>
          <div class="form-floating mb-3">
            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
            <label for="password" class="form-label">Contraseña</label>
              <div class="invalid-feedback" aria-label="Condiciones Contraseña Admin">
                  La contraseña debe tener al menos 6 caracteres, incluyendo letras o números.
              </div>
          </div>
          <button type="submit" id="guardarAdmin" class="btn btn-outline-primary w-25 mx-auto d-block mb-3">Guardar</button>
        </form>
      </div>
    </div>
  </div>
  <?php
  if (!isset($_SESSION['idAdmin'])) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Acceso Denegado
              </div>';
    exit();
  }

