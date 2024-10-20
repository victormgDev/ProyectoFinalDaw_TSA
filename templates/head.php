<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es" data-bs-theme="light" id="html">
<head>
  <meta charset="UTF-8">
  <title>Conoce mas sobre los Aviones</title>
  <link rel="stylesheet" href="/appTsa/css/styles.css">
  <link rel="stylesheet" href="/appTsa/node_modules/bootstrap-icons/font/bootstrap-icons.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
  <script src="/todoSobreAviones/node_modules/jquery/dist/jquery.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</head>
<body class="bg-body">
<nav class="navbar sticky-top navbar-expand-lg bg-light rounded-top-3 mb-3">
  <div class="container-fluid">
    <a class="navbar-brand text-center d-flex justify-content-center p-0" href="/appTsa/index.php" aria-label="Barra de navegacion">
      <img src="/appTsa/img/logoTsA.png" width="40" height="auto">
    </a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="barra de navegacion colapsada">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-menu-app" viewBox="0 0 16 16">
        <path d="M0 1.5A1.5 1.5 0 0 1 1.5 0h2A1.5 1.5 0 0 1 5 1.5v2A1.5 1.5 0 0 1 3.5 5h-2A1.5 1.5 0 0 1 0 3.5zM1.5 1a.5.5 0 0 0-.5.5v2a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 0-.5-.5zM0 8a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm1 3v2a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2zm14-1V8a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v2zM2 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0 4a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5"/>
      </svg>
    </button>


    <div class="collapse navbar-collapse " id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-2">

        <?php if (isset($_SESSION['admin'])):?>
          <li class="nav-item">
            <a class="nav-link" href="/appTsa/indexAdmin.php">Inicio</a>
          </li>

          <li class="nav-item">
            <a class="nav-link"href="/appTsa/miCuentaAdmin.php">
              <i class="bi bi-person"></i> <?php echo ucfirst( $_SESSION['admin']);?> <!--mayusculas en la primera letra usuario-->
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-item" href="/appTsa/modeloControlador/controlador.php?accion=cerrarSesion">
              <i class="bi bi-box-arrow-left"> Cerrar Sesion</i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/appTsa/index.php">Noticias</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/appTsa/vueloActual.php">Vuelos en tiempo Real</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/appTsa/enciclopedia.php">Enciclopedia de Aviones</a>
          </li>
        <?php elseif (isset($_SESSION['usuario'])):?>

          <li class="nav-item">
            <a class="nav-link" href="/appTsa/index.php">Noticias</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/appTsa/vueloActual.php">Vuelos en tiempo Real</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/appTsa/enciclopedia.php">Enciclopedia de Aviones</a>
          </li>
          <li class="nav-item">
            <a class="nav-link"href="/appTsa/miCuenta.php">
              <i class="bi bi-person"></i> <?php echo ucfirst( $_SESSION['usuario']);?> <!--mayusculas en la primera letra usuario-->
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/appTsa/modeloControlador/controlador.php?accion=cerrarSesion">
              <i class="bi bi-box-arrow-left"> Cerrar Sesion</i>
            </a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="/appTsa/login.php">Iniciar Sesión</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/appTsa/logAdmin.php">Iniciar Sesión Admin</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/appTsa/enciclopedia.php">Enciclopedia de Aviones</a>
          </li>
        <?php endif;?>
      </ul>
      <div class="dropdown">
        <button class="btn btn-outline-light border-0 d-flex align-items-center" type="button" id="theme-toggle-btn" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-sun-fill" id="temaIcono"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="theme-toggle-btn">
          <li><a class="dropdown-item" href="#" id="temaLight" onclick="cambiarTema('light')">Modo Claro <i class="bi bi-sun-fill"></i></a></li>
          <li><a class="dropdown-item" href="#" id="temaDark" onclick="cambiarTema('dark')">Modo Oscuro <i class="bi bi-moon-fill"></i></a></li>
        </ul>
      </div>
    </div>
  </div>
</nav>
<script src="/appTsa/js/app.js"  ></script>
<script src="/appTsa/node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
</body>
</html>
