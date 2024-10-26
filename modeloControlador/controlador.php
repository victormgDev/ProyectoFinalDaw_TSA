<?php
include 'modelo.php';

//Funcion para cerrar sesion
if (isset($_GET['accion']) && $_GET['accion'] == 'cerrarSesion') {
  cerrarSesion();
}
function cerrarSesion(){
  session_start();
  session_unset();
  session_destroy();
  header("Location: /appTsa/index.php");
}

//Funcion para mostrar las noticias en el index
function mostrarNoticias($urlRSS, $limite = 12){
  //URL del RSS de googleNoticias
  $rss = simplexml_load_file($urlRSS);
  if ($rss){
    echo '<h1 class="mt-3 text-center animate__animated animate__flip">Noticias </h1>';
    $contador = 0;
    foreach ($rss->channel->item as $item) {
      if($contador >= $limite){
        break;
      }
      echo '<div class="col-12 col-md-6 col-lg-4">';
      echo '<div class="card animate__animated animate__lightSpeedInLeft rounded-4 mt-3">';
      echo '<div class="card card-body rounded-4">';
      echo '<h4 class="card-header  "><a class="text-reset text-decoration-none" href="' . $item->link . '" target="_blank">' . $item->title . '</a></h4>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
      $contador++;
    }

  } else {
    echo 'No se pudieron obtener las noticias en este momento.';
  }
}

//Aqui recibimos los datos de Iniciar Session para comprobar si existe el usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'iniciarSesion') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  iniciarSesion($email, $password);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'registrarUsuario') {
//recuperamos el formulario
  $usuario = $_POST['usuario'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  registrarUsuario($usuario, $email, $password);
}

//Funcion para realizar la busqueda de la descripcion del avion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'buscarDescripcion'){

}

//Funcion para crear Aviones y guardar en BD con los datos recibidos por AJAX de la funcion crearAviones
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'crearAvion') {
  $conn = crearConexion();

//Guardamos en Variables los datos recibidos
  $fabricante = $_POST["fabricante"];
  $modelo = $_POST["modelo"];
  $capacidad = intval($_POST["capacidad"]);
  $velMax = intval($_POST["velMax"]);
  $autonomia = intval($_POST["autonomia"]);
  $descripcion = $_POST["descripcion"];

  crearAvion($fabricante, $modelo, $capacidad, $velMax, $autonomia, $descripcion);
}

//Funcion para mostrar los aviones en la pagina enciclopedia
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'mostrarAviones') {
  $conn = crearConexion();

//Recuperamos los datos enviados por Ajax
  $consulta = isset($_POST['consulta']) ? trim($_POST['consulta']) : '';
  $orden = isset($_POST['orden']) ? $_POST['orden'] : 'fabricante';
  $direccion = isset($_POST['direccion']) ? $_POST['direccion'] : 'ASC';

// Validar valores permitidos para orden y dirección
  $ordenValidos = ['fabricante', 'velocidad_maxima', 'capacidad'];
  $direccionValidos = ['ASC', 'DESC'];

//Si los valores de orden y direccion no son validos aplicamos el valor por defecto
  if (!in_array($orden, $ordenValidos)) {
    $orden = 'fabricante';
  }

  if (!in_array($direccion, $direccionValidos)) {
    $direccion = 'ASC';
  }

  mostrarAviones($consulta, $orden, $direccion);
}

//Funcion para recibir los datos de la modificacion del avion en la pagina detalleAvion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])&& $_POST['action'] === 'editarAvion') {
  $conn = crearConexion();
  if (isset($_POST['idAvion'])) {
    $id1 = ($_POST['idAvion']);
    $descripcion = $_POST['editDescripcion'];
    editarAvion($id1, $descripcion);
  }else{
    echo '<div class=" alert alert-danger text-center" role="alert">no funciona la recepcion</div>';
  }
}

//Codigo para mostrar el auto completado en la busqueda de rutas
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  if ( isset($_POST['consOrigen'])) {
  $autoCompletar = $_POST['consOrigen'];
//Evitar inyecciones SQL
  $autoCompletar = htmlspecialchars($autoCompletar);
  autocompletarOrigen($autoCompletar);
  }
  if (isset($_POST['consDestino'])) {
  $autoCompletar = $_POST['consDestino'];

  //Evitar inyecciones SQL
  $autoCompletar = htmlspecialchars($autoCompletar);
  autocompletarDestino($autoCompletar);
  }
}

//Codigo para buscar Vuelos en la pagina VueloActual
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])&& $_POST['action'] === 'buscarVuelos') {
  session_start();
  if (isset($_SESSION['id']) || isset($_SESSION['idAdmin'])) {
    if (isset($_SESSION['id'])) {
      $idUsuario = $_SESSION['id'];
      echo "<script>var idUsuario= $idUsuario</script>";
      $origen = $_POST['origen'];
      $destino = $_POST['destino'];
      guardarIata($idUsuario, $origen, $destino);//Funcion definida en controlador.php para guardar las consultas de rutas
      mostrarRutas($origen, $destino);

    }
    if (isset($_SESSION['admin'])) {
      $idAdmin = $_SESSION['idAdmin'];
      echo "<script>var idUsuario= $idAdmin</script>";
      $origen = $_POST['origen'];
      $destino = $_POST['destino'];
      guardarIataAdmin($idAdmin, $origen, $destino);//Funcion definida en controlador.php para guardar las consultas de rutas
      mostrarRutas($origen, $destino);
    }
  }

}

//Funcion para comprobar si existe la session de usuario
function existeUsuario(){
  if (isset($_SESSION['id']) || isset($_SESSION['idAdmin'])) {
    if (isset($_SESSION['id'])) {
      $idUsuario = $_SESSION['id'];
    }
    if (isset($_SESSION['idAdmin'])) {
      $idUsuario = $_SESSION['idAdmin'];
    }
    return $idUsuario;
  }
}

//Aqui recibimos los datos de app.js por ajax en la funcion guardarRuta
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['action'])) {
  if ($_POST["action"] === "guardarBusqueda") {
    $idUsuario = $_POST["idUsuario"];
    $origen = $_POST["origen"];
    $destino = $_POST["destino"];
    $modeloAvion = $_POST["modeloAvion"];

    $resultado= guardarBusqueda($idUsuario, $origen, $destino, $modeloAvion);

    if ($resultado) {
      echo "Se guardo correctamente";
    }else{
      echo "No se guardo correctamente";
    }
  }
}

//Aqui recibimos los datos del formulario para editar los datos de mi cuenta
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])&& $_POST['action'] === 'editarMiCuenta') {
  $conn = crearConexion();
  $idUsuario = $_POST['idUsuario'];
  $usuario = $_POST['usuario'];
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
  $email = $_POST['email'];
  if (!empty($usuario) && !empty($password) && !empty($email)) {
    comprobarEmail($idUsuario, $usuario,$email, $password);
  }else{
    echo '<div class=" alert alert-danger text-center" role="alert">Completa todos los campos</div>';
  }
}



?>
