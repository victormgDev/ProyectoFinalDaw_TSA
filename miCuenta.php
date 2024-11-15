<?php
include 'modeloControlador/controlador.php';
include 'templates/head.php';
?>
<?php
if ($idUsuario = existeUsuario()){

}else{
    echo '<div class="alert alert-danger alert-dismissible">Tienes que iniciar sesion</div>';
    include 'templates/footer.php';
    exit();
}
?>
<div class="container-fluid mt5">
  <h3 class="text-center"> Mi Cuenta</h3>
  <div class="row justify-content-center" aria-label="Div para datos de Cuenta">
    <div class="col-9 justify-content-start mb-3 border border-3 rounded-3">
      <?php mostrarMiCuenta(); //funcion para mostrar los datos de la cuenta ?>
    </div>
  </div>
  <div class="row justify-content-center" aria-label="Div para el formulario de modificacion de cuenta">
    <div class="col-9 justify-content-center  mb-3 border border-3 rounded-3">
      <div id="alertFormMiCuenta" aria-label="Div para alertas en la modificacion"></div>
      <div class="form-floating col">
        <h3 class="text-center mt-2">Editar Datos</h3>
        <form id="formEditarMiCuenta" method="POST" class="needs-validation" novalidate onsubmit="editarMiCuenta(<?php echo $_SESSION['idUsuario']; ?>); return false;" >
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="usuarioEdit" name="usuarioEdit" placeholder="Nombre de usuario" required>
            <label for="usuarioEdit" class="form-label">Nombre</label>
              <div class="invalid-feedback">
                  El usuario debe de empezar por minimo 4 letras y le puede seguir un numero
              </div>
          </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control " id="emailEdit" name="emailEdit" placeholder="Usuario@ejemplo.com" required >
                <label for="emailEdit" class="form-label" >Usuario@ejemplo.com</label>
                <div class="invalid-feedback">
                    El email debe comenzar por letra minuscula seguido de @ .com , .es o .org
                </div>
            </div>
          <div class="form-floating mb-3">
            <input type="password" class="form-control" id="passwordEdit" name="passwordEdit" placeholder="Contraseña" required >
            <label for="passwordEdit" class="form-label">Contraseña</label>
              <div class="invalid-feedback">
                  La contraseña debe tener al menos 6 caracteres, incluyendo letras o números.
              </div>
          </div>
          <button id="btnUsuarioEdit" type="submit" class="btn btn-outline-primary w-25 mx-auto d-block mb-3">Guardar</button>
        </form>
      </div>
    </div>
  </div>
  <?php
  if (!isset($_SESSION['idUsuario'])) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                Acceso Denegado
              </div>';
    exit();
  }
  $idUsuario = $_SESSION['idUsuario'];
  ?>
  <div id="datosUsuario" class="row justify-content-center">
    <h3 class="text-center">Mis consultas</h3>
    <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 table-responsive">
      <table class="table table-striped table-bordered table-hover rounded-4 ">
        <thead class="table-light">
        <tr>
          <th>ID Busqueda</th>
          <th>Iata Origen</th>
          <th>Ciudad Origen</th>
          <th>Iata Destino</th>
          <th>Ciudad Destino</th>
          <th>Modelo Avion</th>
          <th>Mostrado Mapa</th>
        </tr>
        </thead>
        <tbody>
        <?php mostrarMisConsultas($idUsuario); ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php include 'templates/footer.php';?>
