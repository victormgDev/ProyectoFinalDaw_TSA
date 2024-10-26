<?php
include 'conexionAdmin.php';

function crearConexion(){
  $connexion = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
  //verificar la conexion
  if(!$connexion){
    die("<br> ERROR DE CONEXION CON LA BASE DE DATOS: " . mysqli_connect_error());
  }
  return $connexion;
}
//Cerrar la conexion
function cerrarConexion($connexion){
  mysqli_close($connexion);
}

//Funcion para iniciar Sesion como Admin
/*function iniciarSesionAdmin($emailAdmin, $passwordAdmin){
  $conn=crearConexion();
  $sql= "SELECT * FROM usuario_admin WHERE email=?";
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("s", $emailAdmin);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    if ($passwordAdmin === $row['password'] || password_verify($passwordAdmin, $row['password'])) {
      session_start();
      $_SESSION['idAdmin'] = $row['id'];
      $idAdmin = $row['id'];
      $_SESSION['admin'] = $row['usuario'];
      $_SESSION['emailAdmin'] = $row['email'];

      if ($row['password_cambiada'] == 0){
        //header('Location: indexAdmin.php' );
        $formulario='
                <form id="formCambiarPassword" method="POST" onsubmit="cambiarPasswordAdmin('.$idAdmin.')"  aria-label="Formulario para Iniciar Sesion como Admin">
                <div class="form-floating mb-3">
                    <input type="password" class="form-control mt-3" id="cambioPasswordAdmin" name="cambioPasswordAdmin" placeholder="Contraseña" required>
                    <label for="cambioPasswordAdmin" class="form-label">Contraseña</label>
                </div>
                <button type="submit" class="btn btn-outline-primary mb-3" >Guardar Cambios</button>
            </form>
            <div id="alertCambioPass"></div>';
        echo $formulario;

      }else{
        echo '<div class="alert alert-success">Ha iniciado sesion como Adminsitrador</div>';
      }
    }else {
      echo '<div class="alert alert-warning">La Contraseña no coincide</div>';
    }
  }else {
    echo '<div class="alert alert-warning">Usuario no encontrado</div>';
  }
  $stmt->close();
  $conn->close();
}*/

//Funcion para cambiar el Password del Admin
function cambiarPasswordAdmin($idAdmin, $nuevoPasswordAdmin){
  $conn=crearConexion();
  $sql = "UPDATE usuario_admin set password=?, password_cambiada=1 where id=?";
  $stmt=$conn->prepare($sql);
  $stmt->bind_param("si",$nuevoPasswordAdmin, $idAdmin );

  if ($stmt->execute()){
    echo '<div class="alert alert-success">Contraseña Modificada correctamente</div>';
  }else{
    echo '<div class="alert alert-warning">No se puede Recuperar la constraseña</div>';
  }
  $stmt->close();
  $conn->close();
}

//Funcion para mostrar los usuarios de la BD
function mostrarUsuarios(){
  $conn=crearConexion();
  $sql="SELECT * FROM usuarios";
  $contadorFila = 0;

  $stmt=$conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows>0){
    while ($row = $result->fetch_assoc()){
      $contadorFila++;
      echo "<tr>
              <th scope='row'>".$contadorFila."</th>
              <td>" .$row['id'].  "</td>
              <td>" .$row['usuario'].  "</td>
              <td>" .$row['email'].  "</td>
              <td>
                <button id='btnEliminarUsuario' class='btn btn-danger' onclick='eliminarUsuario(".$row['id'].")'>
                <span id='spinnerUsuario' class='spinner-border spinner-border-sm d-none'></span>
                 Eliminar
                 </button>
              </td>
              </tr>";
    }
  }
  $stmt->close();
  $conn->close();
}

//Funcion para eliminar Un usuario desde la pagina Admin
function eliminarUsuario($idUsuario){
  $conn=crearConexion();
  $sql = "DELETE FROM usuarios WHERE id = ?";
  $stmt= $conn->prepare($sql);
  $stmt->bind_param('i', $idUsuario);
  if ($stmt->execute()){
    echo '<div class="alert alert-success text-center">Usuario eliminado correctamente</div>';
  }else {
    echo '<div class="alert alert-warning text-center">No se ha podido eliminar el usuario</div>';
  }
  $stmt->close();
  $conn->close();
}

//Funcion para mostrar los aviones de la bd para poder modificar o eliminar
function mostrarAvionesAdmin(){
  $conn=crearConexion();
  $sql="SELECT * FROM aviones";
  $contadorFila = 0;

  $stmt=$conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows>0){
    while ($row = $result->fetch_assoc()){
      $contadorFila++;
      echo "<tr>
              <th scope='row'>".$contadorFila."</th>
              <td>" .$row['id'].  "</td>
              <td>" .$row['fabricante'].  "</td>
              <td>" .$row['modelo'].  "</td>
              <td>
                <button class='btn btn-warning' onclick='modificarAvion(".$row['id'].")'>Modificar</button>
                <button id='btnEliminarAvion' class='btn btn-danger ' onclick='eliminarAvion(".$row['id'].")'>
                <span id='spinnerAvion' class='spinner-border spinner-border-sm d-none'></span>
                Eliminar
                </button>
              </td>
              </tr>";
    }
  }
  $stmt->close();
  $conn->close();
}

//Funcion para eliminar Aviones desde Admin
function eliminarAvion($idAvion){
  $conn=crearConexion();
  $sql = "DELETE FROM aviones WHERE id = ?";
  $stmt= $conn->prepare($sql);
  $stmt->bind_param('i', $idAvion);
  if ($stmt->execute()){
    echo '<div class="alert alert-success text-center">Avion eliminado correctamente</div>';
  }else {
    echo '<div class="alert alert-warning text-center">No se ha podido eliminar el avion</div>';
  }
  $stmt->close();
  $conn->close();
}

//Funcion para mostrar las busquedas en la pagina Admin
function mostrarBusquedasAdmin(){
  $conn=crearConexion();
  $sql="SELECT busquedas.id_usuario, busquedas.id_admin, COALESCE(usuario_admin.usuario, usuarios.usuario) as usuario , busquedas.id_busquedas, busquedas.iata_origen, busquedas.origen, busquedas.iata_destino, busquedas.destino, busquedas.modelo_avion
  from busquedas left join usuarios on busquedas.id_usuario=usuarios.id left join usuario_admin on busquedas.id_admin = usuario_admin.id where busquedas.mostrado_mapa = 'SI'";

  $contadorFila = 0;
  $stmt= $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows>0){
    while ($row = $result->fetch_assoc()){
      $contadorFila++;
      echo "<tr>
              <th scope='row'>".$contadorFila."</th>
              <td>" .$row['id_usuario']. $row['id_admin']. "</td>
              <td>" .$row['usuario'].  "</td>
              <td>" .$row['id_busquedas'].  "</td>
              <td>" .$row['iata_origen'].  "</td>
              <td>" .$row['origen'].  "</td>
              <td>" .$row['iata_destino'].  "</td>
              <td>" .$row['destino'].  "</td>
              <td>" .$row['modelo_avion'].  "</td>
              <td>
                <button id='btnEliminarBusqueda' class='btn btn-danger' onclick='eliminarBusqueda(".$row['id_busquedas'].")'>
                <span id='spinner' class='spinner-border spinner-border-sm d-none'></span>
                Eliminar
                </button>
              </td>
              </tr>";
    }
  }
  $stmt->close();
  $conn->close();
}

//Funcion para eliminar las busquedas de la base de datos
function eliminarBusqueda($idBusqueda){
  $conn=crearConexion();
  $sql = "DELETE FROM busquedas WHERE id_busquedas = ?";
  $stmt= $conn->prepare($sql);
  $stmt->bind_param('i', $idBusqueda);
  if ($stmt->execute()){
    echo '<div class="alert alert-success text-center">Busqueda eliminada Correctamente</div>';
  }else{
    echo '<div class="alert alert-warning text-center">No se han podido eliminar la busqueda</div>';
  }
  $stmt->close();
  $conn->close();
}

//Funcion para eliminar todas las busquedas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'eliminarTotalBusquedas'){
  $conn=crearConexion();
  $sql = "DELETE FROM busquedas";
  $stmt= $conn->prepare($sql);
  if ($stmt->execute()) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">Busquedas eliminadas correctamente</div>';
  }else{
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">Error al eliminar las Busquedas</div>';
  }
}

//Funcion para mostrar datos de Cuenta Admin
function mostrarDatosAdmin($idAdmin){
  $conn=crearConexion();
  $sql="SELECT id, usuario, email, password_cambiada  FROM usuario_admin where id =?";
  $stmt= $conn->prepare($sql);
  $stmt->bind_param('i', $idAdmin);
  if ($stmt->execute()){
    $result = $stmt->get_result();
    if ($result->num_rows > 0){
      $row = $result->fetch_assoc();
      echo '<h3 class="text-center">Datos</h3>';
      echo '<div id="datosFormMiCuentaAdmin">';
      echo '<h6 class="text-center">Nombre: '.$row['usuario']. '</h6>';
      echo '<h6 class="text-center">Email: '.$row['email']. '</h6>';
      echo '<h6 class="text-center">Contraseña Cambiada: '.$row['password_cambiada']. ' vez.</h6>';
      echo '</div>';
    }else{
      echo '<div class=" alert alert-danger text-center" role="alert">Usuario no encontrado</div>';
    }
  }
}

function comprobarEmailAdmin($idAdmin, $usuario,$email, $password){
  $conn=crearConexion();
  $sql1 = "SELECT * FROM usuario_admin WHERE email=?";
  $stmt1 = $conn->prepare($sql1);
  $stmt1->bind_param("s", $email);
  $stmt1->execute();
  $result = $stmt1->get_result();
  if ($result->num_rows > 0){
    echo '<div class="alert alert-danger text-center mt-3" role="alert">El email ya existe</div>';
  }else{
    $sql = "UPDATE usuario_admin SET usuario=?, password=?, email=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $usuario, $password, $email, $idAdmin);
    if ($stmt->execute()) {
      echo '<h6 class="text-center">Nombre: '.$usuario. '</h6>';
      echo '<h6 class="text-center">Email: '.$email. '</h6>';
    }else{
      echo '<div class=" alert alert-danger text-center" role="alert">Error al editar datos</div>';
    }
  }

}

?>
