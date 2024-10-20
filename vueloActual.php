<?php
include 'modeloControlador/controlador.php';
include 'templates/head.php';
?>
<script src="js/app.js"></script>
<?php
//Si el usuario no esta registrado o no ha iniciado sesion no podemos acceder al formulario para consultar rutas
if ($idUsuario = existeUsuario()) {

  /*if(isset($_SESSION['id'])){
    $idUsuario = $_SESSION['id'];
    echo "<script>var idUsuario= $idUsuario</script>";
  }
  if(isset($_SESSION['admin'])){
    $idUsuario = $_SESSION['idAdmin'];
    echo "<script>var idUsuario= $idUsuario</script>";
  }*/
  echo ' <!-- Codigo para mostrar el mapa si el usuario a iniciado sesion-->
<div class="container-fluid">
    <div class="row justify-content-center" id="mapa" aria-label="Mapa de aviones">
        <h1 class="text-center animate__animated animate__flip">Mapa para tu vuelo en Tiempo Real</h1>
                <div class="col-10">
                    <div id="map" style="height: 500px;  width: 100%;">
                    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCl4vk039FPjcdPlIDjZ3dQutSH_bMnuqI"></script>
                    <script>mostrarMapa()</script>
                    </div>
                </div>
    </div>
    <div class="row justify-content-center" aria-label="Resultados de vuelos en tiempo real">
        <div class="col-12">
           <h1 class="mt-3 text-center animate__animated animate__flip">Busca tu vuelo en tiempo real</h1>
              <div class="alert alert-info mt-3" role="alert">
                    Ingresa un codigo de origen y destino validos
              </div>
                <form id="formBuscarVuelos" class="form-control" method="POST" onsubmit="buscarVuelos()">
                    <label for="origen" class="form-label">
                        <a href="https://es.wikipedia.org/wiki/Anexo:Aeropuertos_según_el_código_IATA#A" target="_blank" class="text-decoration-none text-reset">Codigo IATA de Origen</a>
                    </label>
                    <input type="text" id="origen" name="origen" class="form-control" required>
                    <div class="list-group" id="listaOrigen"></div>

                    <label for="destino" class="form-label">
                        <a href="https://es.wikipedia.org/wiki/Anexo:Aeropuertos_según_el_código_IATA#A" target="_blank" class="text-decoration-none text-reset">Codigo IATA de Destino</a>
                    </label>
                    <input type="text" id="destino" name="destino" class="form-control" required>
                    <div class="list-group" id="listaDestino"></div>
                    <button type="submit" class="btn btn-outline-primary mt-3">Buscar Vuelos</button>
                </form>
        </div>
    </div>

    <div id="resultadosBuscarVuelos" class="row justify-content-center"></div>';
}else {
  echo '
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-9 col-sm-8 col-md-7 col-lg-6 ">
                <div class="alert alert-info d-flex justify-content-between align-items-center " role="alert">
                Tienes que iniciar sesion
                        <a class="btn  btn-outline-primary align-content-end " href="login.php">Iniciar sesion</a>
                </div>
            </div>
        </div>
    </div>
    ';
}


?>
<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
<footer>
  <?php
  include 'templates/footer.php';
  ?>
</footer>
