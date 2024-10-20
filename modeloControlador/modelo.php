<?php
include 'conexion.php';

//Crear Conexion
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

//Funcion para iniciar session y comprobar en la BD si existe el usuario
function iniciarSesion ($email, $password){
  $conn = crearConexion();

  $sql= "SELECT * FROM usuarios WHERE email=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0){
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])){
      session_start();
      $_SESSION['id'] = $user['id'];
      $_SESSION['usuario'] = $user['usuario'];
      $_SESSION['email'] = $user['email'];
      $_SESSION['idUsuario'] = $user['id'];

      echo '<div class="col-9 alert alert-success text-center" role="alert">Bienvenido al sistema</div>';
      exit();
    }else{
      echo '<div class="col-9 alert alert-warning text-center">Contraseña Incorrecta</div>';
    }
  }else {
    echo '<div class="col-9 alert alert-danger text-center">Usuario no encontrado</div>';
  }
  $conn->close();
  $stmt->close();
}

//Funcion para registrar usuario en la BD
function registrarUsuario($usuario, $email, $password){
  $conn = crearConexion();

  //Comprobamos si existe el usuario a registrar en la BD
  $sql = "SELECT id FROM usuarios WHERE  email=?";
  $consulta = $conn->prepare($sql);
  $consulta->bind_param('s', $email);
  $consulta->execute();
  $consulta->store_result();

  if ($consulta->num_rows > 0) {
    echo '<div class="col-9 alert alert-danger text-center" role="alert">El usuario ya existe</div>';
  }else{
    $sql1="INSERT INTO usuarios (usuario, email, password) VALUES (?,?,?)";
    $stmt = $conn->prepare($sql1);
    $stmt->bind_param('sss', $usuario, $email, $password);
    if($stmt->execute()){
      echo '<div class="col-9 alert alert-success text-center" role="alert">Usuario registrado correctamente</div>';

    }else{
      echo '<div class="col-9 alert alert-danger text-center">Error al registrar el usuario</div>';
    }
    $stmt->close();
    $conn->close();
  }

}

//Funcion para crear el avion en la BD
function crearAvion($fabricante, $modelo, $capacidad, $velMax, $autonomia, $descripcion){
  $conn = crearConexion();
  //Sentencia para comprobar si el modelo ya existe
  $sql1 = "SELECT id FROM aviones WHERE modelo=?";
  $stmt1 = $conn->prepare($sql1);
  $stmt1->bind_param('s', $modelo);
  $stmt1->execute();
  $stmt1->store_result();//Aqui almacenamos los resultados
  if ($stmt1->num_rows > 0){ //Comprobamos si existe el modelo
    echo '<div class=" alert alert-danger text-center" role="alert">El avion ya existe</div>';
  }else{
    //Para subir la imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
      $dirSubida = __DIR__ . "/../img/";
      $nombreImagen = basename($_FILES['imagen']['name']);
      $url = "http://localhost/appTsa/img/" . $nombreImagen;
      $rutaImagen = $dirSubida . $nombreImagen;

      //Movemos la imagen al directorio
      if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
        //Consulta Sql
        $sql= "INSERT INTO aviones (fabricante, modelo, capacidad, velocidad_maxima, autonomia, descripcion, imagen_url) values (?,?,?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiiiss", $fabricante, $modelo, $capacidad, $velMax, $autonomia, $descripcion, $url);

        if ($stmt->execute()) {
          echo "<div class='alert alert-success text-center' role='alert'>Avion creado correctamente</div>";
        }else {
          echo "<div class='alert alert-danger text-center' role='alert'>Error al crear el avion</div>";
        }
      }else {
        echo "<div class='alert alert-danger text-center' role='alert'>Error al subir la imagen</div>";
      }
    }else{
      echo "<div class='alert alert-warning text-center' role='alert'>Desbes subir una imagen</div>";
    }
  }
}

//Funcion para msotrar los aviones en la pagina enciclopedia
function mostrarAviones($consulta, $orden,$direccion){
  $conn = crearConexion();
  // Si no introducimos ninguna consulta en en el inseert, mostramos todos los aviones
  if ($consulta === '') {
    $sql = "SELECT * FROM aviones ORDER BY $orden $direccion";
    $stmt = $conn->prepare($sql);
  } else {
    $sql = "SELECT * FROM aviones WHERE fabricante LIKE ? OR modelo LIKE ? ORDER BY $orden $direccion";
    $stmt = $conn->prepare($sql);
    $terminoBusqueda = '%' . $consulta . '%';
    $stmt->bind_param("ss", $terminoBusqueda, $terminoBusqueda);
  }

  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      echo "
            <div class='card mb-3'>
                <div class='row g-0'>
                    <div class='col-md-4'>
                        <a href='detalleAvion.php?id=" . $row['id'] . "'>
                            <img src='" . htmlspecialchars($row['imagen_url']) . "' class='img-fluid rounded-start' alt='imagen avión'>
                        </a>
                    </div>
                    <div class='col-md-8'>
                        <div class='card-body'>
                            <a class='text-decoration-none text-reset' href='detalleAvion.php?id=" . $row['id'] . "'>
                                <h5 class='card-title'>" . htmlspecialchars($row['fabricante']) . " " . $row['modelo'] . "</h5>
                            </a>
                        </div>
                    </div>
                </div>
            </div>";
    }
  } else {
    echo '<p>No se encontraron coincidencias</p>';
  }
  $stmt->close();
  $conn->close();
}

//Funcion para mostrar la pagina de detallesAvion
function detalleAvion(){
  if (isset($_GET['id'])){
    $conn=crearConexion();
    $id= intval($_GET['id']);
    $sql= "SELECT * FROM aviones WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0){
      $row = $result->fetch_assoc();

      echo '<h2>'.htmlspecialchars($row['fabricante']).' - '.htmlspecialchars($row['modelo']).'</h2>';
      echo '<img src="' . htmlspecialchars($row["imagen_url"]) . '" class="img-fluid" alt="imagen avión">';
      echo '<div id="divDescripcion">';
      echo '<p>Descripcion: '.htmlspecialchars($row["descripcion"]).'</p>';
      echo '</div>';
      echo '<p>Capacidad: '.htmlspecialchars($row["capacidad"]).'</p>';
      echo '<p>Velocidad Maxima: '.htmlspecialchars($row["velocidad_maxima"]).' km/h</p>';
    }else{
      echo '<div class=" alert alert-danger text-center" role="alert">Avion no encontrado</div>';
    }
    if (isset($_SESSION['usuario'])|| isset($_SESSION['admin'])){
      echo '<div class="col-10 mt-0">';
      echo '<div class="row mb-3">';
      echo '<form id="formEditAvion" class="form-control" method="post">';
      echo '<label for="editDescripcion" class="form-label">Editar Descripcion</label>';
      echo '<textarea class="form-control" id="editDescripcion" name="editDescripcion" rows="5"></textarea>';
      echo '</div>';
      echo '<button type="submit" class="btn btn-outline-primary" id="editAvion" name="editAvion" onclick="editarAvion('.$_GET['id'].')">Guardar Cambios</button>';
      echo '</form>';
      echo '</div>';
    }
  }
}

//Funcion para guardar la modificacion de editar avion
function editarAvion($id1, $descripcion){
  $conn = crearConexion();
  $sql1 = "UPDATE aviones SET descripcion = ? WHERE id=?";
  $stmt1 = $conn->prepare($sql1);
  $stmt1->bind_param("si", $descripcion, $id1);
  if ($stmt1->execute()) {
    echo '<div class=" alert alert-success text-center" role="alert">Avion editado Correctamente</div>';
    echo '<p>Descripcion: '.$descripcion.'</p>';
  }else{
    echo '<div class=" alert alert-danger text-center" role="alert">Error al editar el avion</div>';
  }
}

//Funcion para mostrar autocompletado en el input Origen y Destino
function autocompletarOrigen($autoCompletar){
  $conn = crearConexion();

  $sql = "select * from aeropuertos where iata like ? or nombre like ? or ciudad like ? or icao like ? limit 5";
  $stmt = $conn->prepare($sql);
  $busqueda = "%$autoCompletar%";
  $stmt->bind_param("ssss", $busqueda, $busqueda, $busqueda, $busqueda);
  $stmt->execute();
  $result = $stmt->get_result();

  //generamos la lista de resultados
  if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
      echo '<li class="list-group-item origen" data-iata="' . htmlspecialchars($row['iata']).'">' .htmlspecialchars($row['iata']). ' - ' .htmlspecialchars($row['nombre']).'</li>';
    }

  }else{
    echo '<ul class="list-group"><li class="list-group-item">No se encontraron resultados</li></ul>';
  }
  $stmt->close();
  $conn->close();
  exit();
}
function autocompletarDestino($autoCompletar){
  $conn = crearConexion();
  //sentencia SQL
  $sql = "select iata, nombre from aeropuertos where iata like ? or nombre like ? or ciudad like ? or icao like ? limit 5";
  $stmt = $conn->prepare($sql);
  $busqueda = "%$autoCompletar%";
  $stmt->bind_param("ssss", $busqueda, $busqueda, $busqueda, $busqueda);
  $stmt->execute();
  $result = $stmt->get_result();

  //generamos la lista de resultados
  if ($result->num_rows > 0){

    while($row = $result->fetch_assoc()){
      echo '<li class="list-group-item destino" data-iata="' . htmlspecialchars($row['iata']).'">' .htmlspecialchars($row['iata']). ' - ' .htmlspecialchars($row['nombre']).'</li>';
    }

  }else{
    echo '<ul class="list-group"><li class="list-group-item">No se encontraron resultados</li></ul>';
  }
  $stmt->close();
  $conn->close();
  exit();
}


//Funcion para mostrar las rutas en la pagina vuelo actual
function mostrarRutas($origen, $destino){
  $conn=crearConexion();
  //Coordenadas de Orgien
  $sql="SELECT latitud, longitud FROM aeropuertos WHERE iata like ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $origen);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
      $latOrigen=$row['latitud'];
      $lngOrigen=$row['longitud'];
    }
  }
  //Coordenadas de Destino
  $sql1="SELECT latitud, longitud FROM aeropuertos WHERE iata like ?";
  $stmt1 = $conn->prepare($sql1);
  $stmt1->bind_param("s", $destino);
  $stmt1->execute();
  $result1 = $stmt1->get_result();
  if ($result1->num_rows > 0){
    while($row = $result1->fetch_assoc()){
      $latDestino=$row['latitud'];
      $lngDestino=$row['longitud'];
    }
  }
  $claveApi = '417a76ab448ab04d5a14accd43d3f95c'; //clave para hacer las consultas
  //Url de aviaton stack para consultar las rutas en tiempo real
  $url= "http://api.aviationstack.com/v1/flights?access_key=$claveApi&dep_iata=$origen&arr_iata=$destino";

  //inciamos Curl para aviaton stak
  $canal = curl_init($url);
  curl_setopt($canal,CURLOPT_URL, $url);
  curl_setopt($canal,CURLOPT_RETURNTRANSFER,true);
  $respuesta  = curl_exec($canal);
  curl_close($canal);

  //Descodificamos el JSON
  $rutas = json_decode($respuesta, true);

  //Comprobamo si se han obtenido respuestas
  if (isset($rutas['data']) && !empty($rutas['data'])) { //comprobamos que existe el array $rutas y preguntamos si no esta vacio
    //Traduccion de estados de Vuelo
    $estadosVuelo=[
      'scheduled' => 'Programado',
      'active' => 'En vuelo',
      'landed' => 'Aterrizado',
      'cancelled' => 'Cancelado',
      'incident' => 'Incidente',
      'diverted' => 'Desviado'
    ];
    //Devolvemos los datos
    foreach ($rutas['data'] as $vuelo) {
      //Obtenemos el estado del vuelo
      $estado = $vuelo['flight_status'];
      //Verificamos si el estado existe en la traduccion
      $estadoEs = isset($estadosVuelo[$estado]) ? $estadosVuelo[$estado] : 'Desconocido';

      //Convertimos la hora a la hora local usando zonas horarias
      $zonaHorariaSalida = $vuelo['departure']['timezone'];
      $zonaHorariaLlegada = $vuelo['arrival']['timezone'];

      //Convertimos la horaUtc a hora local
      $horaSalidaUtc = new DateTime($vuelo['departure']['estimated']);
      $horaLlegadaUtc = new DateTime($vuelo['arrival']['estimated']);

      //clonamos las horas utc y aplicamos la zona horaria
      $horaSalida = clone $horaSalidaUtc;
      $horaSalida->setTimezone(new DateTimeZone($zonaHorariaSalida));
      $horaLlegada = clone $horaLlegadaUtc;
      $horaLlegada->setTimezone(new DateTimeZone($zonaHorariaLlegada));

      switch ($estado) {
        case 'active':
        case 'scheduled':
          echo '<div class="col-12 col-md-6 col-lg-4">';
          echo '<div class="card animate__animated animate__lightSpeedInLeft mt-3">';
          echo '<div class="card-header">';
          echo "Vuelo: " . $vuelo['flight']['iata'] . "<br>";
          echo '</div>';
          echo '<div class="card-body">';
          echo '<h5 class="card-title">Aerolinea: ' . $vuelo['airline']['name'] . '</h5>';
          echo '<p class="card-text">Origen: ' . $vuelo['departure']['airport'] . "<br></p>";
          echo '<p class="card-text">Destino: ' . $vuelo['arrival']['airport'] . "<br></p>";
          if (isset($vuelo['aircraft']['icao'])) {
            $_SESSION['modeloAvion'] = $vuelo['aircraft']['icao'];
            echo '<p class="card-text">Código IATA del Avión: ' . $vuelo['aircraft']['icao'] . "<br></p>";
          } else {
            echo '<p class="card-text">Código IATA del Avión no disponible.</p>';
          }
          echo '<p class="card-text">Estado: ' . $estadoEs . "<br></p>";
          if (isset($vuelo['live']['latitude']) && isset($vuelo['live']['longitude'])) {
            if (isset($_SESSION['id'])){
              $idUsuario=$_SESSION['id'];
            }
            if (isset($_SESSION['idAdmin'])){
              $idUsuario=$_SESSION['idAdmin'];
            }
            if (isset($vuelo['live']['direction'])){
              $direccion=$vuelo['live']['direction'];
            }
            $lat= $vuelo['live']['latitude'];
            $lng= $vuelo['live']['longitude'];
            echo '<p class="card-text">Latitud: ' . $vuelo['live']['latitude'] . "<br></p>";
            echo '<p class="card-text">Longitud: ' . $vuelo['live']['longitude'] .  "</p>";
            echo "<button class='btn btn-outline-success btn-sm' id='btnMostrar' onclick='guardarRuta($idUsuario, \"$origen\", \"$destino\", \"{$_SESSION['modeloAvion']}\", $lat, $lng, $direccion, $latOrigen,$lngOrigen, $latDestino, $lngDestino)'>Mostrar en el Mapa</button>";//funcion para guardar el avion de la ruta y origen y destino
            // Botón para mostrar en el mapa
          } else {
            echo '<p class="card-text">Información de ubicación no disponible.</p>';
          }
          echo '<p class="card-text">Salida Estimada (UTC): ' . $horaSalidaUtc->format('Y-m-d H:i') . "<br></p>";
          echo '<p class="card-text">Salida Estimada: ' . $horaSalida->format('Y-m-d H:i') . "<br></p>";
          echo '<p class="card-text">Llegada Estimada (UTC): ' . $horaLlegadaUtc->format('Y-m-d H:i') . "<br></p>";
          echo '<p class="card-text">Llegada Estimada: ' . $horaLlegada->format('Y-m-d H:i') . "<br></p>";
          echo '</div>';
          echo '</div>';
          echo '</div>';
          break;
      }
    }
  }else {
    echo '<div class="alert alert-warning" role="alert">
                        No se han encontrado rutas
                      </div>';;
  }
}

//Funcion para Guardar la busqueda sin mostrar en el mapa
function guardarIata($idUsuario, $origen,$destino ){
  $conn=crearConexion();
  $sql = "INSERT INTO busquedas (id_usuario, iata_origen, iata_destino) VALUES (?,?,?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('iss',$idUsuario,$origen,$destino);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
    echo '<div class="col-9 mt-3 alert alert-success text-center">
                Busqueda Guardada Correctamente
              </div>';
    $conn->close();
    $stmt->close();
    return true;
  }else{
    echo '<div class="col-9 mt-3 alert alert-danger text-center">
                Error al guardar la busqueda
                </div>';
    $conn->close();
    $stmt->close();
    return false;
  }
}

// Funcion para guardar la busqueda de ruta
function guardarBusqueda($idUsuario, $origen, $destino, $modeloAvion){
  //Creamos la conexion
  $conn=crearConexion();

  //Sentencia SQL select para recuperar datos de la tabla aeropuertos
  $sql= "SELECT id ,ciudad, iata FROM aeropuertos where iata in (?,?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $origen, $destino);
  $stmt->execute();
  $resultado = $stmt->get_result();

  $idAeropuertoOrigen=null;
  $idAeropuertoDestino=null;
  $ciudadOrigen = '';
  $ciudadDestino = '';
  $mostradoMapa = 'SI';

  if ($resultado->num_rows > 0) {
    while ($aeropuerto = $resultado->fetch_assoc()){
      if ($aeropuerto['iata'] === $origen) {
        $idAeropuertoOrigen = $aeropuerto['id'];
        $ciudadOrigen = $aeropuerto['ciudad'];
      }elseif ($aeropuerto['iata'] === $destino) {
        $idAeropuertoDestino = $aeropuerto['id'];
        $ciudadDestino = $aeropuerto['ciudad'];
      }
    }
  }else {
    echo 'No se encontraron resultados';
  }
  //Sentencia SQL insert
  $sql1 = "INSERT INTO busquedas (id_usuario,id_aeropuerto_origen, iata_origen, origen, id_aeropuerto_destino, iata_destino, destino, modelo_avion, mostrado_mapa) VALUES (?,?,?,?,?,?,?,?,?)";
  $stmt1=$conn->prepare($sql1);
  $stmt1->bind_param("iississss",$idUsuario,$idAeropuertoOrigen,$origen, $ciudadOrigen,$idAeropuertoDestino,$destino,$ciudadDestino,$modeloAvion, $mostradoMapa);
  $stmt1->execute();

  return $stmt1->affected_rows >0; //devuelve true si se ha completado el insert
}

//Funcion para la pagina miCuenta.php para mostrar los datos de la cuenta de usuario y el formulario para editar datos
function mostrarMiCuenta(){
  $conn=crearConexion();
  $idUsuario= $_SESSION['idUsuario'];
  $sql= "SELECT * FROM usuarios WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $idUsuario);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0){
    $row = $result->fetch_assoc();
    echo '<h3 class="text-center">Datos</h3>';
    echo '<div id="datosFormMiCuenta">';
    echo '<h6 class="text-center">Nombre: '.$row['usuario']. '</h6>';
    echo '<h6 class="text-center">Email: '.$row['email']. '</h6>';
    echo '</div>';
  }else{
    echo '<div class=" alert alert-danger text-center" role="alert">Usuario no encontrado</div>';
  }
}

//Funcion para comporbar si existe el email introducido para ver si se puede modificar
function comprobarEmail($idUsuario, $usuario,$email, $password){
  $conn=crearConexion();
  $sql1 = "SELECT * FROM usuarios WHERE email=?";
  $stmt1 = $conn->prepare($sql1);
  $stmt1->bind_param("s", $email);
  $stmt1->execute();
  $result = $stmt1->get_result();
  if ($result->num_rows > 0){
    echo '<div class="alert alert-danger text-center mt-3" role="alert">El email ya existe</div>';
  }else{
    $sql = "UPDATE usuarios SET usuario=?, password=?, email=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $usuario, $password, $email, $idUsuario);
    if ($stmt->execute()) {
      echo '<h6 class="text-center">Nombre: '.$usuario. '</h6>';
      echo '<h6 class="text-center">Email: '.$email. '</h6>';
    }else{
      echo '<div class=" alert alert-danger text-center" role="alert">Error al editar datos</div>';
    }
  }

}

//Funcion para mostrar las consultas de vuelos en la pagina miCuenta.php
function mostrarMisConsultas($idUsuario){
  $conn=crearConexion();

  //Consulta de recuperacion
  $sql= "SELECT * FROM busquedas where id_usuario = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i",$idUsuario);
  $stmt->execute();
  $result = $stmt->get_result();

  //Guardamos en Array los datos
  $busquedas = [];
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()){
      echo "<tr>
              <td>" .$row['id_busquedas'].  "</td>
              <td>" .$row['iata_origen'].  "</td>
              <td>" .$row['origen'].  "</td>
              <td>" .$row['iata_destino'].  "</td>
              <td>" .$row['destino'].  "</td>
              <td>" .$row['modelo_avion'].  "</td>
              <td>" .$row['mostrado_mapa'].  "</td>
              </tr>";
    }
  }else {
    echo '<tr><td colspan="5">Aun no has realizado ninguna Busqueda</td></tr>';
  }
}


?>
