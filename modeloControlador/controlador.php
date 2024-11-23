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
      echo '<div class="card card-body rounded-4 ">';
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

//Aqui recibimos los datos del formulario de registrar usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'registrarUsuario') {
  //Expresion regular para la contraseña de al menos 6 caracteres
  function validarPassword($password){
    return preg_match('/^[A-Za-z0-9]{6,}$/', $password);
  }
//recuperamos el formulario
  $usuario = $_POST['usuarioRegistro'];
  $email = $_POST['emailRegistro'];
  $password = $_POST['passwordRegistro'];
  if (validarPassword($password)) {
    echo '<div class="col-9 alert alert-success text-center" role="alert">Contraseña valida</div>';
    $password = password_hash($_POST['passwordRegistro'], PASSWORD_DEFAULT);
    registrarUsuario($usuario, $email, $password);
  }else{
    echo '<div class="col-9 alert alert-danger text-center">La contraseña debe de contener 6 caracteres minimo letras o numeros</div>';
  }
}

//Funcion para realizar la busqueda de la descripcion del avion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'buscarDescripcion'){
  $fabricantesAviones = ['boeing', 'airbus', 'bombardier', 'atr', 'gulfstream'];
$fabricante = strtolower(trim($_POST['fabricante']));
$modelo = $_POST['modelo'];

if (in_array($fabricante, $fabricantesAviones)){
  $tituloBusqueda = urlencode(str_replace(' ', '_', $fabricante . ' ' . $modelo));
  $url = "https://es.wikipedia.org/w/api.php?action=query&format=json&prop=extracts&exintro&explaintext&titles=$tituloBusqueda";

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, 'AplicacionTsa/1.0(victormon.7777@gmail.com)');
  $respuesta = curl_exec($ch);
  curl_close($ch);

  if ($respuesta) {
    $datos = json_decode($respuesta, true);
    $paginas = $datos['query']['pages'];

    $descripcion = '';
    foreach ($paginas as $pagina) {
      if (isset($pagina['extract'])) {
        $descripcion .= $pagina['extract'] . ', ';
        break;
      }
    }
    preg_match('/\b(\d+)\s*pasajeros?\b/i', $descripcion, $capacidad);
    preg_match('/alcance.*?(\d+(?:\s?\d{3})*)\s?(km|kilómetros)/i', $descripcion, $alcance);
    preg_match('/velocidad.*?(\d+(?:\s?\d{3})*)\s?(km\/h)/i', $descripcion, $velocidad);
    $capacidad_texto = isset($capacidad[1]) ? $capacidad[1] : '0';
    $alcance_texto = isset($alcance[1]) ? $alcance[1] : '0';
    $velocidad_texto = isset($velocidad[1]) ? $velocidad[1] : '0';


    // Mostrar la descripción y los detalles encontrados
    echo '<h5>Descripción del avión:</h5>';
    echo "<div id='descripcionAvion'><p>$descripcion</p></div>";

    echo '<h5>Capacidad:</h5>';
    if ($capacidad_texto === '0') {
      echo '<p>No se encontró información de capacidad.</p>';
      echo '<label for="capacidadManual">Ingrese la capacidad:</label>';
      echo '<div id="capacidadAvion"><input type="text" id="capacidadManual" name="capacidadManual" class="form-control" placeholder="Ej. 300 pasajeros" required></div>';
    } else {
      echo '<div id="capacidadAvion"><p>' . $capacidad_texto . ' pasajeros</p></div>';
    }
    echo '<h5>Alcance:</h5>';
    if ($alcance_texto === '0') {
      echo '<p>No se encontró información de alcance.</p>';
      echo '<label for="alcanceManual">Ingrese el alcance:</label>';
      echo '<div id="alcanceAvion"><input type="text" id="alcanceManual" name="alcanceManual" class="form-control" placeholder="Ej. 15000 km" required></div>';
    } else {
      echo '<div id="alcanceAvion"><p>' .$alcance_texto . ' kilometros</p></div>';
    }
    echo '<h5>Velocidad:</h5>';
    if ($velocidad_texto === '0') {
      echo '<p>No se encontró información de la velocidad.</p>';
      echo '<label for="velocidadManual">Ingrese la velocidad:</label>';
      echo '<div id="velocidadAvion"><input type="text" id="velocidadManual" name="velocidadManual" class="form-control" placeholder="Ej. 900 km/h" required></div>';
    } else {
      echo '<div id="velocidadAvion"><p>' . $velocidad_texto . ' km/h</p></div>';
    }
    echo '<h5>Codigos icao del modelo</h5>';
    echo '<label for="codigosIcao">Ingrese los codigos ICAO separados por una (,):</label>';
    echo '<div id="codigosIcaoAvion"><input type="text" id="codigosIcao" name="codigosIcao" class="form-control" placeholder="Ej. B737, B38M" required></div>';
  } else {
    echo 'Error al conectar con Wikipedia.';
  }
}else{
  echo '<div class="alert alert-warning">No has introducido un fabricante de avion valido</div>';
}

}

//Funcion para procesar los datos del avion creado para guardarlo en la BD
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'crearAvionBusqueda') {
  $fabricante = $_POST['fabricante'];
  $modelo = $_POST['modelo'];
  $descripcion = $_POST['descripcion'];
  $capacidad = $_POST['capacidad'];
  $alcance = $_POST['alcance'];
  $velocidad = $_POST['velocidad'];
  $codigosIata = $_POST['codigosIcao'];
  session_start();
  if (isset($_SESSION['id'])){
    $idUsuario = $_SESSION['id'];
    crearAvionBusqueda($fabricante, $modelo, $descripcion, $capacidad, $alcance, $velocidad,$idUsuario,$codigosIata);
  }else {
    $idUsuario = $_SESSION['idAdmin'];
    crearAvionBusqueda($fabricante, $modelo, $descripcion, $capacidad, $alcance, $velocidad,$idUsuario, $codigosIata);
  }

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
  session_start();
  if (isset($_POST['idAvion'])) {
    $id1 = ($_POST['idAvion']);
    if (isset($_SESSION['usuario']) || isset($_SESSION['admin'])){
      if (isset($_SESSION['usuario'])){
        $usuario = $_SESSION['usuario'];
      }elseif (isset($_SESSION['admin'])){
        $usuario = $_SESSION['admin'];
      }
      $descripcionGuardada= $_POST['descripcionGuardada'];
      $descripcion = $_POST['editDescripcion'];
      $descripcionCompleta= $descripcionGuardada . "<br><h6>Informacion añadida por " .$usuario . "</h6>\n" . $descripcion;
      editarAvion($id1, $descripcion, $descripcionCompleta);
    }
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

//Funcion para mostrar el avion en la busqueda
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'mostrarInfoAvion'){
  $iata = $_POST['iata'];
  mostrarInfoAvion($iata);
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
  $usuario = $_POST['usuarioEdit'];
  $password = password_hash($_POST['passwordEdit'], PASSWORD_BCRYPT);
  $email = $_POST['emailEdit'];
  if (!empty($usuario) && !empty($password) && !empty($email)) {
    comprobarEmail($idUsuario, $usuario,$email, $password);
  }else{
    echo '<div class=" alert alert-danger text-center" role="alert">Completa todos los campos</div>';
  }
}



?>
