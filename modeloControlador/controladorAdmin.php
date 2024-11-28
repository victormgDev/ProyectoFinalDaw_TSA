<?php
include 'modeloAdmin.php';

//Funcion para recibir por fetch los datos de inicio como admin y comprobarlos con la bd y si es el primer inicio creamos un formulario para cambiar la contraseña
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'iniciarSesionAdmin') {
  $emailAdmin = $_POST['emailAdmin'];
  $passwordAdmin = $_POST['passwordAdmin'];

  iniciarSesionAdmin($emailAdmin, $passwordAdmin);
}
//Funcion para cambiar la contraseña de admin en el primer inicio de sesion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'cambiarPasswordAdmin') {
  $nuevoPasswordAdmin = password_hash($_POST['cambioPasswordAdmin'], PASSWORD_DEFAULT);
  $idAdmin = $_POST['idAdmin'];
  if (!empty($idAdmin) && !empty($nuevoPasswordAdmin)){
    cambiarPasswordAdmin($idAdmin, $nuevoPasswordAdmin);
  }else{
    echo '<div class="alert alert-warning">Datos incompletos</div>';
  }
}

//Funcion para recibir los doatos del usuario para eliminar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'eliminarUsuario') {
  $idUsuario = $_POST['idUsuario'];
  eliminarUsuario($idUsuario);
}

//Funcion para eliminar el avion desde Admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'eliminarAvion') {
  $idAvion = $_POST['idAvion'];
  eliminarAvion($idAvion);
}

//Funcion para eliminar la busqueda
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'eliminarBusqueda') {
  $idBusqueda = $_POST['idBusqueda'];
  eliminarBusqueda($idBusqueda);
}

//Funcion para mostrar en el modal la informacion añadida por el usuario para validarla
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'mostrarRevision'){
  $idAvion = $_POST['idAvion'];
  mostrarRevision($idAvion);
}

//Funcion para deshacer la informacion añadida por el usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'denegarRevision'){
  $idAvion = $_POST['idAvion'];
  denegarRevision($idAvion);
}

//Funcion para revisar el avion y reiniciar el estado de revision del avion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'revisarAvion') {
  $idAvion = $_POST['idAvion'];
  reiniciarEstado($idAvion);
}

//Aqui recibimos los datos del formulario para editar los datos de mi cuenta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])&& $_POST['action'] === 'editarMiCuentaAdmin') {
  $conn = crearConexion();
  $idAdmin = $_POST['idAdmin'];
  $usuario = $_POST['usuario'];
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
  $email = $_POST['email'];
  if (!empty($usuario) && !empty($password) && !empty($email)) {
    comprobarEmailAdmin($idAdmin, $usuario,$email, $password);
  }else{
    echo '<div class=" alert alert-danger text-center" role="alert">Completa todos los campos</div>';
  }
}

?>

