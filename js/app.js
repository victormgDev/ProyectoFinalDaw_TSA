// Función para cambiar el tema y el ícono en el head
function cambiarTema(tema) {
  const htmlElement = document.getElementById('html');
  htmlElement.setAttribute('data-bs-theme', tema);
  localStorage.setItem('tema', tema); // Guardar en localStorage

  const iconoTema = document.getElementById('temaIcono');
  if (tema === 'light') {
    iconoTema.classList.remove('bi-moon-fill');
    iconoTema.classList.add('bi-sun-fill');
  } else {
    iconoTema.classList.remove('bi-sun-fill');
    iconoTema.classList.add('bi-moon-fill');
  }
}

// Asignar eventos a los botones del menú desplegable de seleccion de tema
document.getElementById('temaLight').addEventListener('click', function() {
  cambiarTema('light');
});
document.getElementById('temaDark').addEventListener('click', function() {
  cambiarTema('dark');
});

// Aplicar el tema guardado al cargar la página
window.onload = function() {
  const temaGuardado = localStorage.getItem('tema') || 'light'; // Por defecto tema claro
  cambiarTema(temaGuardado);
}

//Funcion para recibir los datos del formulario de Iniciar Sesion
function iniciarSesion(){
  event.preventDefault();
  let form =document.querySelector('#formIniciarSesion');
  let formDatos = new FormData(form);
  formDatos.append('action', 'iniciarSesion');
  fetch('modeloControlador/controlador.php', {
    method: 'POST',
    body: formDatos,
  })
    .then(response =>response.text())
    .then(data => {
      if (data.includes('div class="col-9 alert alert-success text-center" role="alert">Bienvenido al sistema</div>')) {  // Suponiendo que el servidor devuelve este mensaje
        // Redirigir a index.php
        window.location.href = '/appTsa/index.php';
      }else{
        document.querySelector('#alertFormIniciarSesion').innerHTML = data;
      }
    })
    .catch(error => {
      console.error('Error al iniciar Sesion', error);
    })
}

//Funcion para registrar usuario
function registrarUsuario(usuario,email,password){
  console.log("funciona el boton");
  event.preventDefault();
  let form =document.querySelector('#registroForm');

  let formDatos = new FormData(form);
  formDatos.append('action', 'registrarUsuario');

  fetch('modeloControlador/controlador.php', {
    method: 'POST',
    body: formDatos,
  })
    .then(response =>response.text())
    .then(data => {
      document.querySelector('#alertRegistro').innerHTML = data;
    })
    .catch(error => {
      document.querySelector('#alertRegistro').innerHTML = data;
    })
}

//Funcion para crear Aviones y añadir a la base de datos
function crearAvion(){
  console.log("funciona el boton");
  event.preventDefault();

  let form =document.querySelector('#formCrearAvion');
  let formDatos = new FormData(form);
  formDatos.append('action', 'crearAvion');
  fetch('modeloControlador/controlador.php', {
    method: 'POST',
    body: formDatos,
  })
    .then(response =>response.text())
    .then(data => {
      document.querySelector('#alertCrearAvion').innerHTML = data;
    })
    .catch(error => {
      console.error('Error al crear Avion', error);
    })
}

//Funcion para mostrar aviones con datos recibidos de enciclopedia.php y enviamos datos a controlador.php para que nos devuelva la informacion
function mostrarAviones() {
  event.preventDefault();
  //Guardamos en variable los datos del formulario a traves del id del formulario
  let form =document.querySelector('#formBusquedaAviones');

  //Creamops objeto formData
  let formDatos = new FormData(form);
  formDatos.append('action', 'mostrarAviones');

  //Realizamos solicitud Ajax
  fetch('modeloControlador/controlador.php', {
    method: 'POST',
    body: formDatos,
  })
    .then(response =>response.text())//recibimos como html
    .then(data => {
      document.querySelector('#resultados').innerHTML = data;
    })
    .catch(error => {
      console.error('Error al buscar aviones: ', error);
    })
}

//Funcion para guardar modificaciones del avion de la pagina detallesAvion.php
function editarAvion(idAvion){
  console.log(idAvion);
  event.preventDefault();
  let form =document.querySelector('#formEditAvion');

  let formDatos = new FormData(form);
  console.log(formDatos);
  formDatos.append('action', 'editarAvion');
  formDatos.append('idAvion', idAvion);
  fetch('modeloControlador/controlador.php', {
    method: 'POST',
    body: formDatos,
  })
    .then(response =>response.text())
    .then(data => {
      console.log(data)
      document.querySelector('#divDescripcion').innerHTML = data;
    })
    .catch(error => {
      console.error('Error al editar Avion', error);
    })
}

//Funcion para mostrar mapa en vueloActual.php
var map; // variable map para que este al alcance de la funcion  marcadorAvion
function mostrarMapa(){
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCl4vk039FPjcdPlIDjZ3dQutSH_bMnuqI";

  function initMap() {
    var location = { lat: 40.416775, lng: -3.703790 }; // Coordenadas de Madrid
    map = new google.maps.Map(document.getElementById("map"), {
      zoom: 6,
      center: location
    });

    var marker = new google.maps.Marker({
      position: location,
      map: map,
      title: "Madrid"
    });
  }
  window.onload = initMap;
}

//Autocompletar para origen y destino
$(document).ready(function() {
  // Autocompletar para Origen
  $('#origen').on('input', function() {
    var conOrigen = $(this).val();
    if (conOrigen.length > 1) {
      $.ajax({
        url: 'modeloControlador/controlador.php',
        method: 'POST',
        data: { consOrigen: conOrigen },
        success: function(data) {
          $('#listaOrigen').html(data);
        }
      });
    } else {
      $('#listaOrigen').html('');
    }
  });
  // Selección de aeropuerto en Origen
  $(document).on('click', '.list-group-item.origen', function() {
    var codigoIata = $(this).data('iata'); //guardamos en variable el codigo iata
    $('#origen').val(codigoIata);//Colocar solo el codigo Iata en el input para realizar la consulta a la api
    $('#listaOrigen').html('');
  });

  // Autocompletar para Destino
  $('#destino').on('input', function() {
    var conDestino = $(this).val();
    if (conDestino.length > 1) {
      $.ajax({
        url: 'modeloControlador/controlador.php',
        method: 'POST',
        data: { consDestino: conDestino },
        success: function(data) {
          $('#listaDestino').html(data);
        }
      });
    } else {
      $('#listaDestino').html('');
    }
  });

  // Selección de aeropuerto en Destino
  $(document).on('click', '.list-group-item.destino', function() {
    var codigoIata = $(this).data('iata'); //guardamos en variable el codigo iata
    $('#destino').val(codigoIata); //Colocar solo el codigo Iata en el input para realizar la consulta a la api
    $('#listaDestino').html(''); // Al hacer click limpiamos la lista
  });
});

//Funcion para buscarVuelos, recogemos los datos del formulario para enviarlos al controlador
function buscarVuelos(){
  event.preventDefault();
  console.log('Funciona el boton');
  let form= document.querySelector('#formBuscarVuelos');
  let formDatos = new FormData(form);
  formDatos.append('action', 'buscarVuelos');
  fetch('modeloControlador/controlador.php', {
    method: 'POST',
    body: formDatos,
  })
  .then(response =>response.text())
  .then(data => {
    document.querySelector('#resultadosBuscarVuelos').innerHTML = data;
  })
  .catch(error => {
    console.error('Error al buscar Vuelos', error);
  })
}

//Funcion para trazar la ruta en el mapa desde el Origen al Avion
function trazarRutaOrigen(lat, lng, latOrigen, lngOrigen) {
  var ruta = new google.maps.Polyline({
    path: [
      { lat: latOrigen, lng: lngOrigen }, // Punto de inicio
      { lat: lat, lng: lng } // Punto de destino
    ],
    geodesic: true, // Línea geodésica
    strokeColor: '#FF0000', // Color de la línea
    strokeOpacity: 1.0, // Opacidad de la línea
    strokeWeight: 2 // Grosor de la línea
  });

  // Añade la línea al mapa
  ruta.setMap(map);
}

//Funcion para trazar ruta desde el Avion Al destino
function trazarRutaDestino(lat, lng, latDestino, lngDestino) {
  var ruta = new google.maps.Polyline({
    path: [
      { lat: lat, lng: lng }, // Punto de inicio
      { lat: latDestino, lng: lngDestino } // Punto de destino
    ],
    geodesic: true, // Línea geodésica
    strokeColor: '#1dcd14', // Color de la línea
    strokeOpacity: 1.0, // Opacidad de la línea
    strokeWeight: 2 // Grosor de la línea
  });

  // Añade la línea al mapa
  ruta.setMap(map);
}

//Funcion para añadir el marcador con la posicion del Avion en vuelo
function marcadorAvion(lat, lng, direccion, latOrigen, lngOrigen, latDestino, lngDestino) {
  console.log("Añadiendo marcador en: ", lat, lng, direccion);
  var ubicacion = new google.maps.LatLng(lat, lng);

  // Crear un nuevo overlay
  var markerOverlay = new google.maps.OverlayView();

  markerOverlay.onAdd = function () {
    var div = document.createElement('div');
    div.style.position = 'absolute';
    div.style.width = '30px';
    div.style.height = '30px';
    div.style.backgroundImage = "url('img/iconoAvion.png')";
    div.style.backgroundSize = 'cover';

    // Aplicar la rotación
    div.style.transform = 'rotate(' + direccion + 'deg)';

    this.div = div;

    var panes = this.getPanes();
    panes.overlayLayer.appendChild(div);
  };

  markerOverlay.draw = function () {
    var projection = this.getProjection();
    var position = projection.fromLatLngToDivPixel(ubicacion);

    var div = this.div;
    div.style.left = (position.x - 15) + 'px';
    div.style.top = (position.y -15) + 'px';
  };

  markerOverlay.onRemove = function () {
    this.div.parentNode.removeChild(this.div);
    this.div = null;
  };

  markerOverlay.setMap(map);  // Agregar el overlay al mapa

  //Llamamos a la funcion para trazal la ruta
  trazarRutaOrigen(latOrigen, lngOrigen, lat, lng);
  trazarRutaDestino(latDestino, lngDestino, lat, lng);
}
//Funcion para guardar la Ruta completa una vez msotrado en el mapa el avion
function guardarRuta(idUsuario, origen, destino, modeloAvion, lat, lng, direccion, latOrigen, lngOrigen, latDestino, lngDestino){
  console.log("funciona el boton");
  marcadorAvion(lat,lng, direccion, latOrigen, lngOrigen, latDestino, lngDestino);

  $.ajax({
    url: 'modeloControlador/controlador.php',
    method: 'POST',
    data: {
      action: 'guardarBusqueda',
      idUsuario: idUsuario,
      origen: origen,
      destino: destino,
      modeloAvion: modeloAvion,
    },
    success: function(response) {
      console.log(response);
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.error('Error al guardar la busqueda: ', textStatus, errorThrown);
    }
  })
}

//Funcion para recibir los datos del formulario de mi cuenta para editar los datos de usuario
function editarMiCuenta(idUsuario){
  event.preventDefault();
  console.log(idUsuario);
  let form =document.querySelector('#formEditarMiCuenta');
  let formDatos = new FormData(form);
  formDatos.append('action', 'editarMiCuenta');
  formDatos.append('idUsuario', idUsuario);
  fetch('modeloControlador/controlador.php', {
    method: 'POST',
    body: formDatos,
  })
    .then(response =>response.text())
    .then(data => {
      if (data.includes('<div class="alert alert-danger text-center mt-3" role="alert">El email ya existe</div>')) {
        document.querySelector('#alertFormMiCuenta').innerHTML = data;
      }else{
        document.querySelector('#alertFormMiCuenta').innerHTML = '<div class="alert alert-success text-center mt-3">Usuario modificado Correctamente</div>';
        document.querySelector('#datosFormMiCuenta').innerHTML = data;
      }

    })
    .catch(error => {
      console.error('Error al mostrarMiCuenta', error);
    })
}

//Funcion para hacer Login como Administrador en la pagina logAdmin.php
function iniciarSesionAdmin(event){
  event.preventDefault();
  console.log('funciona el boton');

  let form =document.querySelector('#formLoginAdmin');
  let formDatos = new FormData(form);
  formDatos.append('action', 'iniciarSesionAdmin');

  fetch('modeloControlador/controladorAdmin.php', {
    method: 'POST',
    body: formDatos,
  })
    .then(response =>response.text())
    .then(data => {
      if (data.includes('<div class="alert alert-success">Ha iniciado sesion como Adminsitrador</div>')){
        window.location.href = 'indexAdmin.php';
      }else{
        document.querySelector('#divCambiarPasword').innerHTML = data;

      }
    })
    .catch(error => {
      console.error('Error al login Admin', error);
    })
}

//Funcion para cambiar la contraseña del usuario admin
function cambiarPasswordAdmin(idAdmin){
  event.preventDefault();
  console.log('funciona el boton');

  let form =document.querySelector('#formCambiarPassword');
  let formDatos = new FormData(form);
  formDatos.append('action', 'cambiarPasswordAdmin');
  formDatos.append('idAdmin', idAdmin);

  fetch('modeloControlador/controladorAdmin.php', {
    method: 'POST',
    body: formDatos,
  })
    .then(response =>response.text())
    .then(data => {
      if (data.includes('Contraseña Modificada correctamente')){
        window.location.href = 'logAdmin.php';
      }else {
        document.querySelector('#alertCambioPass').innerHTML = data;
      }

    })
    .catch(error => {
      console.error('Error al cambiarPassword', error);
    })
}

//Funcion para eliminar usuario desde indexAdmin
function eliminarUsuario(idUsuario){
  if (confirm("Estas seguro de eliminar el usuario?")) {
    fetch('modeloControlador/controladorAdmin.php', {
      method: 'POST',
      body: new URLSearchParams({
        'idUsuario': idUsuario,
        'action': 'eliminarUsuario'
      })
    })
      .then(response =>response.text())
      .then(data => {
        alert(data);
        location.reload();
      })
      .catch(error => {
        console.error('Error al eliminar el usuario', error);
      })
  }
}

//Funcion para modificar el avion que nso redirige a la pagina de editar avion
function modificarAvion(id){
  window.location.href= 'detalleAvion.php?id='+id;
}

//Funcion para eliminar el Avion desde Admin
function eliminarAvion(idAvion){
  if (confirm("Estas seguro de eliminar el Avion?")) {
    fetch('modeloControlador/controladorAdmin.php', {
      method: 'POST',
      body: new URLSearchParams({
        'idAvion': idAvion,
        'action': 'eliminarAvion'
      })
    })
      .then(response =>response.text())
      .then(data => {
        alert(data);
        location.reload();
      })
      .catch(error => {
        console.error('Error al eliminar el usuario', error);
      })
  }
}

//Funcion para redirigir a pagina crear Avion desde Admin
function crearAvionAdmin(){
  window.location.href= 'crearAvion.php';
}

//Funcion para recibir los datos del formulario de mi cuenta Admin para editar los datos de Admin
function editarMiCuentaAdmin(idAdmin){
  event.preventDefault();
  console.log(idAdmin);
  let form =document.querySelector('#formEditarMiCuentaAdmin');
  let formDatos = new FormData(form);
  formDatos.append('action', 'editarMiCuentaAdmin');
  formDatos.append('idAdmin', idAdmin);
  fetch('modeloControlador/controladorAdmin.php', {
    method: 'POST',
    body: formDatos,
  })
    .then(response =>response.text())
    .then(data => {
      if (data.includes('<div class="alert alert-danger text-center mt-3" role="alert">El email ya existe</div>')) {
        document.querySelector('#alertFormMiCuentaAdmin').innerHTML = data;
      }else{
        document.querySelector('#alertFormMiCuentaAdmin').innerHTML = '<div class="alert alert-success text-center mt-3">Usuario modificado Correctamente</div>';
        document.querySelector('#alertFormMiCuentaAdmin').innerHTML = data;
        document.querySelector('#datosFormMiCuentaAdmin').innerHTML = data;
      }

    })
    .catch(error => {
      console.error('Error al mostrarMiCuenta', error);
    })
}

