<?php
include 'templates/head.php';
include 'modeloControlador/controladorAdmin.php';

if (isset($_SESSION['admin'])){
  echo'
    <div class="container-fluid">
        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmación</h5>
                <button type="button" class="close" id="btnCerrarModal" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                ¿Estás seguro de que quieres eliminar?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelarEliminar" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmarEliminar">Eliminar</button>
              </div>
            </div>
          </div>
        </div>
    <h3 class="text-center border-bottom border-4"> Pagina Administrador</h3>
    <div class="row justify-content-center">
        <div class="col-9 ">
            <h3 class="text-center border-bottom">Usuarios</h3>
            <div id="alertUsuariosMostrados"> </div>
            <table class="table table-hover ">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Id Usuario</th>
                    <th scope="col">Nombre </th>
                    <th scope="col">Email</th>
                </tr>
                </thead>
                <tbody>
                ';  mostrarUsuarios();  echo '
                </tbody>
            </table>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-9">
            <h3 class="text-center border-bottom mt-5">Aviones</h3>
            <div id="alertAvionesMostrados"></div>
            <table class="table table-hover ">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Id Avion</th>
                    <th scope="col">Fabricante </th>
                    <th scope="col">Modelo</th>
                    <th scope="col"><button class="btn btn-outline-primary" onclick="crearAvionAdmin()">Crear Avion</button></th>
                </tr>
                </thead>
                <tbody>
                '; mostrarAvionesAdmin(); echo '
                </tbody>
            </table>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-9">

            <h3 class="text-center border-bottom mt-5">Busquedas mostradas en Mapa</h3>
            <div id="alertBusquedasMostradas"></div>
            <table class="table table-hover ">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Id Usuario</th>
                    <th scope="col">Usuario</th>
                    <th scope="col">Id Busqueda</th>
                    <th scope="col">Iata Origen </th>
                    <th scope="col">Origen</th>
                    <th scope="col">Iata Destino</th>
                    <th scope="col">Destino</th>
                    <th scope="col">Modelo Avion</th>
                    <th scope="col"><button class="btn btn-danger" onclick="eliminarTotalBusquedas()">Borrar lista</button></th>
                </tr>
                </thead>
                <tbody>
                '; mostrarBusquedasAdmin(); echo '
                </tbody>
            </table>
        </div>
    </div>
</div>
    ';
}else {
  echo '<div class="alert alert-warning">Inicia session como administrador</div>';
}
?>
<script src="node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>

<?php
include 'templates/footer.php';
?>
