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
      }else if (data.includes('<div class="alert alert-success text-center">Ha iniciado sesion como Adminsitrador</div>')) {
        document.querySelector('#alertFormIniciarSesion').innerHTML = data;
        setTimeout(function (){
          window.location.href = '/appTsa/indexAdmin.php';
        }, 2000);
      }else {
        document.querySelector('#alertFormIniciarSesion').innerHTML = data;
      }
    })
    .catch(error => {
      console.error('Error al iniciar Sesion', error);
    })
}

//Funcion para registrar usuario
document.addEventListener('DOMContentLoaded', function() {
  const usuarioInput = document.getElementById('usuarioRegistro');
  const emailInput = document.getElementById('emailRegistro');
  const passwordInput = document.getElementById('passwordRegistro');
  const registerButton = document.getElementById('btnRegistro'); // Obtén el botón de registro

  // Desactiva el botón de registro inicialmente
  registerButton.disabled = true;
  emailInput.disabled = true;
  passwordInput.disabled = true;
  usuarioInput.addEventListener('input', function() {
    const usuario = this.value;
    const regex = /^[A-Za-z]{4,}[0-9]*$/;

    if (regex.test(usuario)) {
      this.classList.remove("is-invalid");
      this.classList.add("is-valid");
      emailInput.disabled = false;

    } else {
      this.classList.remove("is-valid");
      this.classList.add("is-invalid");
      registerButton.disabled = true; // Desactivar el botón de registro
      emailInput.disabled = true;
    }
  });

  emailInput.addEventListener('input', function() {
    const email = this.value;
    const regex = /^[a-z]+@[a-z]+\.(com|es|org)$/;

    if (regex.test(email)) {
      this.classList.remove("is-invalid");
      this.classList.add("is-valid");
      passwordInput.disabled = false;

    } else {
      this.classList.remove("is-valid");
      this.classList.add("is-invalid");
      registerButton.disabled = true; // Desactivar el botón de registro
      passwordInput.disabled = true;

    }
  });

  passwordInput.addEventListener('input', function() {
    const password = this.value;
    const regex = /^[A-Za-z0-9]{6,}$/;

    if (regex.test(password)) {
      this.classList.remove("is-invalid");
      this.classList.add("is-valid");
      registerButton.disabled = false; // Activar el botón de registro
    } else {
      this.classList.remove("is-valid");
      this.classList.add("is-invalid");
      registerButton.disabled = true; // Desactivar el botón de registro
    }
  });
});
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
      if (data.includes('El usuario ya existe')){
        document.querySelector('#alertRegistro').innerHTML = data
      }else{
        document.querySelector('#alertRegistro').innerHTML = data;
        setTimeout(function (){
          window.location.href = '/appTsa/login.php'
        },1500);
      }
    })
    .catch(error => {
      document.querySelector('#alertRegistro').innerHTML = data;
    })
}

//Funcion para buscarDescripcion de Aviones
function buscarDescripcion(){
  console.log("funciona el boton");
const fabricante = document.getElementById('fabricante').value;
const modelo = document.getElementById('modelo').value.toUpperCase();

const descripcionContenedor = document.getElementById('divDescripcionAvion');
  console.log(fabricante, modelo );
if (!fabricante || !modelo){
  descripcionContenedor.innerHTML= "<p class='text-warning'>Completa el Fabricante y Modelo. </p>";
  return;
}
fetch('modeloControlador/controlador.php', {
  method: 'POST',
  headers:{
    'content-type': 'application/x-www-form-urlencoded',
  },
  body: new URLSearchParams({
    fabricante: fabricante,
    modelo: modelo,
    descripcionContenedor: descripcionContenedor,
    action: 'buscarDescripcion',
  })
})
  .then(response =>response.text())
  .then(data => {
    descripcionContenedor.innerHTML=data;
  })
  .catch(error => {
    console.error('Error al buscar la descripcion', error);
    descripcionContenedor.innerHTML='<p class="text-danger">Error al obtener la descripcion</p>';
  });
}

//Funcion para crear el avion mostrado en la busqueda
function crearAvionBusqueda(){
  console.log("funciona el boton crearAvionBusqueda");
  event.preventDefault();
  const descripcion = document.getElementById('descripcionAvion').innerText;
  const capacidad = document.getElementById('capacidadAvion').innerText || document.getElementById('capacidadManual').value;
  const alcance = document.getElementById('alcanceAvion').innerText || document.getElementById('alcanceManual').value;
  const velocidad = document.getElementById('velocidadAvion').innerText || document.getElementById('velocidadManual').value;
  const codigosIcao = document.getElementById('codigosIcao').innerText || document.getElementById('codigosIcao').value;

  const capacidadNum = parseInt(capacidad.replace(/\D/g, ''), 10);
  const alcanceNum = parseInt(alcance.replace(/\D/g, ''), 10);
  const velocidadNum = parseInt(velocidad.replace(/\D/g, ''), 10);

  let form= document.querySelector('#formCrearAvion');
  let formDatos = new FormData(form);
  formDatos.append('action', 'crearAvionBusqueda');
  formDatos.append('descripcion', descripcion);
  formDatos.append('capacidad', capacidadNum);
  formDatos.append('alcance', alcanceNum);
  formDatos.append('velocidad', velocidadNum);
  formDatos.append('codigosIcao', codigosIcao);

  fetch('modeloControlador/controlador.php', {
    method: 'POST',
    body: formDatos
  })
    .then(response =>response.text())
    .then(data => {
      if (data.includes('<div class=\'alert alert-warning text-center\' role=\'alert\'>Desbes subir una imagen</div>')){
        document.querySelector('#alertCrearAvion').innerHTML = data;
      }else{
        document.querySelector('#alertCrearAvion').innerHTML = data;
        setTimeout(function (){
          window.location.href = '/appTsa/enciclopedia.php'
        }, 1500);
      }

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
  const descripcionGuardada = document.getElementById('divDescripcion').innerText;
  let form =document.querySelector('#formEditAvion');

  let formDatos = new FormData(form);
  console.log(formDatos);
  formDatos.append('action', 'editarAvion');
  formDatos.append('idAvion', idAvion);
  formDatos.append('descripcionGuardada', descripcionGuardada);
  fetch('modeloControlador/controlador.php', {
    method: 'POST',
    body: formDatos,
  })
    .then(response =>response.text())
    .then(data => {
      setTimeout(function (){
        location.reload();
      }, 1500);
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
 src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyCl4vk039FPjcdPlIDjZ3dQutSH_bMnuqI";
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

//Funcion para mostrar el avion en la busqueda
function mostrarInfoAvion(iata){
console.log('Funciona el boton de mostrar avion')
let formDatos = new FormData();
formDatos.append('action', 'mostrarInfoAvion');
formDatos.append('iata', iata)

  fetch('modeloControlador/controlador.php', {
    method: 'POST',
    body: formDatos,
  })
      .then(response =>response.text())
      .then(data =>{
        document.querySelector(`#infoAvion${iata}`).innerHTML = data
      })
      .catch(error =>{
        console.error('Error al mostrar el avion', error);
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
document.addEventListener('DOMContentLoaded', function() {
  const usuarioInputEdit = document.getElementById('usuarioEdit');
  const emailInputEdit = document.getElementById('emailEdit');
  const passwordInputEdit = document.getElementById('passwordEdit');
  const registerButtonEdit = document.getElementById('btnUsuarioEdit'); // Obtén el botón de registro

  // Desactiva el botón de registro inicialmente
  registerButtonEdit.disabled = true;
  emailInputEdit.disabled = true;
  passwordInputEdit.disabled = true;
  usuarioInputEdit.addEventListener('input', function() {
    const usuario = this.value;
    const regex = /^[A-Za-z]{4,}[0-9]*$/;

    if (regex.test(usuario)) {
      this.classList.remove("is-invalid");
      this.classList.add("is-valid");
      emailInputEdit.disabled = false;


    } else {
      this.classList.remove("is-valid");
      this.classList.add("is-invalid");
      registerButtonEdit.disabled = true; // Desactivar el botón de registro
      emailInputEdit.disabled = true;
    }
  });

  emailInputEdit.addEventListener('input', function() {
    const email = this.value;
    const regex = /^[a-z]+@[a-z]+\.(com|es|org)$/;

    if (regex.test(email)) {
      this.classList.remove("is-invalid");
      this.classList.add("is-valid");
      passwordInputEdit.disabled = false;


    } else {
      this.classList.remove("is-valid");
      this.classList.add("is-invalid");
      registerButtonEdit.disabled = true; // Desactivar el botón de registro
      passwordInputEdit.disabled = true;
    }
  });

  passwordInputEdit.addEventListener('input', function() {
    const password = this.value;
    const regex = /^[A-Za-z0-9]{6,}$/;

    if (regex.test(password)) {
      this.classList.remove("is-invalid");
      this.classList.add("is-valid");
      registerButtonEdit.disabled = false; // Activar el botón de registro

    } else {
      this.classList.remove("is-valid");
      this.classList.add("is-invalid");
      registerButtonEdit.disabled = true; // Desactivar el botón de registro
    }
  });
});
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
        setTimeout(function () {
          location.reload();
        }, 2500);
      }

    })
    .catch(error => {
      console.error('Error al mostrarMiCuenta', error);
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
        window.location.href = 'login.php';
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
  var boton = document.getElementById('btnEliminarUsuario');
  var spinner = document.getElementById('spinnerUsuario');
  $('#confirmModal').modal('show');
  document.getElementById('cancelarEliminar').addEventListener('click', function (){
    $('#confirmModal').modal('hide');
  })
  document.getElementById('btnCerrarModal').addEventListener('click', function (){
    $('#confirmModal').modal('hide');
  })

  document.getElementById('confirmarEliminar').addEventListener('click',function (){
    $('#confirmModal').modal('hide');
    boton.disabled=true;
    spinner.classList.remove('d-none');
    fetch('modeloControlador/controladorAdmin.php', {
      method: 'POST',
      body: new URLSearchParams({
        'idUsuario': idUsuario,
        'action': 'eliminarUsuario'
      })
    })
      .then(response =>response.text())
      .then(data => {
        document.querySelector('#alertUsuariosMostrados').innerHTML=data;
        setTimeout(function (){
          location.reload();
        }, 3500);
      })
      .catch(error => {
        console.error('Error al eliminar el usuario', error);
        boton.disabled=false;
        spinner.classList.add('d-none');
      });
  });
}

//Funcion para modificar el avion que nso redirige a la pagina de editar avion
function modificarAvion(id){
  window.location.href= 'detalleAvion.php?id='+id;
}

//Funcion para eliminar el Avion desde Admin
function eliminarAvion(idAvion){
  var boton =  document.getElementById('btnEliminarAvion');
  var spinner =  document.getElementById('spinnerAvion');
  $('#confirmModal').modal('show');
  document.getElementById('cancelarEliminar').addEventListener('click', function (){
    $('#confirmModal').modal('hide');
  })
  document.getElementById('btnCerrarModal').addEventListener('click', function (){
    $('#confirmModal').modal('hide');
  })

  document.getElementById('confirmarEliminar').addEventListener('click',function (){
    $('#confirmModal').modal('hide');
    boton.disabled=true;
    spinner.classList.remove('d-none');
    fetch('modeloControlador/controladorAdmin.php', {
      method: 'POST',
      body: new URLSearchParams({
        'idAvion': idAvion,
        'action': 'eliminarAvion'
      })
    })
      .then(response =>response.text())
      .then(data => {
        document.querySelector('#alertAvionesMostrados').innerHTML= data
        setTimeout(function (){
          location.reload();
        }, 3500);
      })
      .catch(error => {
        console.error('Error al eliminar el usuario', error);
        boton.disabled=false;
        spinner.classList.add('d-none');
      });
  });
}

//Funcion para eliminar Busquedas
function eliminarBusqueda(idBusqueda){
  var boton = document.getElementById('btnEliminarBusqueda');
  var spinner = document.getElementById('spinner');
  $('#confirmModal').modal('show');
  document.getElementById('cancelarEliminar').addEventListener('click', function (){
    $('#confirmModal').modal('hide');
  })
  document.getElementById('btnCerrarModal').addEventListener('click', function (){
    $('#confirmModal').modal('hide');
  })

  document.getElementById('confirmarEliminar').addEventListener('click',function (){
    $('#confirmModal').modal('hide');
    boton.disabled=true;
    spinner.classList.remove('d-none');
    fetch('modeloControlador/controladorAdmin.php', {
      method: 'POST',
      body: new URLSearchParams({
        'idBusqueda': idBusqueda,
        'action': 'eliminarBusqueda'
      })
    })
      .then(response =>response.text())
      .then(data => {
        document.querySelector('#alertBusquedasMostradas').innerHTML = data;
        setTimeout(function (){
          location.reload();
        }, 3500);

      })
      .catch(error => {
        console.error('Error al eliminar la busqueda', error);
        boton.disabled=false;
        spinner.classList.add('d-none');
      });
  });
}
//Funcion para eliminar todas las busquedas
function eliminarTotalBusquedas(){
  console.log('funciona el boton');
  if (confirm("¿Estas seguro de eliminar todas las busquedas?")) {
    fetch('modeloControlador/modeloAdmin.php', {
      method: 'POST',
      body: new URLSearchParams({
        'action': 'eliminarTotalBusquedas'
      })
    })
      .then(response =>response.text())
      .then(data => {
        document.querySelector('#alertBusquedasMostradas').innerHTML = data;
        setTimeout(function (){
          location.reload();
        }, 3500);
      })
      .catch(error => {
        console.error('Error al eliminar la busqueda', error);
      })
  }
}

//Funcion para redirigir a pagina crear Avion desde Admin
function crearAvionAdmin(){
  window.location.href= 'avion.php';
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

