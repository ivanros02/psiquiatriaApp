<?php
session_start(); // Asegúrate de iniciar la sesión en todas las páginas

// Verificar si el usuario está logueado
$usuarioLogueado = false;
$nombreUsuario = '';  // Variable para almacenar el nombre del usuario

if (isset($_SESSION['user_id'])) {
  $usuarioLogueado = true;
  $nombreUsuario = $_SESSION['user_nombre'];  // Recuperar el nombre del usuario de la sesión
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Terapia Libre</title>

  <!--icono pestana-->
  <link rel="icon" href="../img/Logo_transparente.png" type="image/x-icon">
  <link rel="shortcut icon" href="../img/Logo_transparente.png" type="image/x-icon">

  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <!-- custom css file link  -->
  <link rel="stylesheet" href="../estilos/headerYFooter.css">
  <link rel="stylesheet" href="../estilos/stylePsico.css">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- Agrega los scripts de Bootstrap y jQuery justo antes de cerrar la etiqueta </body> -->
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script src="./js/psicologos.js" defer></script>

  <style>
    .form-select {
      font-size: 1.8rem !important;
      color: #c1c700;
    }

    /* Estilo personalizado para aumentar el tamaño de fuente en el select */
    select.form-select option {
      font-size: 1.8rem !important;
      /* Puedes ajustar este valor según lo que necesites */
    }
  </style>
</head>

<body>

  <!-- header section starts  -->

  <header class="d-flex justify-content-between align-items-center bg-white shadow fixed-top p-2">
    <a href="../index.php" class="logo d-flex align-items-center text-decoration-none text-success mx-auto mx-lg-0">
      <img src="../img/Logo_transparente.png" alt="Logo de Terapia Libre" class="mr-2" style="width: 7rem;">
      <span>Terapia Libre</span>
    </a>

    <nav class="navbar navbar-expand-lg navbar-light d-none d-lg-flex">
      <ul class="navbar-nav ml-auto">
        <li><a href="../index.php">Inicio</a></li>
        <li><a href="#service">Beneficios</a></li>
        <!-- Mostrar "Perfil" si el usuario está logueado -->
        <?php if ($usuarioLogueado): ?>
          <li class="nav-item">
            <a class="nav-link" href="../usuario/dashboard/dashboard.php">Hola,
              <strong><?php echo htmlspecialchars($nombreUsuario); ?></strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../usuario/control/logout.php">Cerrar sesión</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="../usuario/index.php">Iniciar sesión</a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>

    <!-- Menú tipo TikTok solo visible en móviles -->
    <nav class="mobile-navbar d-lg-none fixed-bottom bg-white p-2 shadow">
      <ul class="d-flex justify-content-between w-100 text-center">
        <li class="nav-item">
          <a class="nav-link" href="../index.php">
            <i class="fas fa-home"></i>
            <span>Inicio</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#service">
            <i class="fas fa-heart"></i>
            <span>Beneficios</span>
          </a>
        </li>
        <!-- Mostrar "Perfil" si el usuario está logueado en el menú móvil -->
        <?php if ($usuarioLogueado): ?>
          <li>
            <a href="../usuario/dashboard/dashboard.php">
              <i class="fas fa-user"></i>
              <p>Hola, <strong><?php echo htmlspecialchars($nombreUsuario); ?></strong></p>
              <!-- Mostrar el nombre del usuario -->
            </a>
          </li>
          <li>
            <a href="../usuario/control/logout.php">
              <i class="fas fa-sign-out-alt"></i>
              <p>Cerrar sesión</p>
            </a>
          </li>
        <?php else: ?>
          <li>
            <a href="../usuario/index.php">
              <i class="fas fa-user"></i>
              <p>Iniciar sesión</p>
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>

  </header>

  <!--header section ends-->

  <!--Psicologos start-->
  <section id="profesionales">
    <h1 class="heading"> PROFESIONALES </i></h1>

    <div class="container my-4">
      <!-- Formulario de filtros con Bootstrap -->
      <form id="filterForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" class="row g-3">
        <!-- Filtro de especialidad -->
        <div class="col-md-4">
          <label for="especialidadFilter" class="form-label fs-5">Especialidad:</label>
          <select id="especialidadFilter" name="especialidadFilter" class="form-select form-select-xl">
            <option value="">Cargando...</option>
          </select>
        </div>

        <!-- Filtro de disponibilidad -->
        <div class="col-md-4">
          <label for="disponibilidadFilter" class="form-label fs-5">Disponibilidad:</label>
          <select id="disponibilidadFilter" name="disponibilidadFilter" class="form-select form-select-xl">
            <option value="">Todas las disponibilidades</option>
            <option value="24hs">24hs</option>
            <option value="48hs">48hs</option>
            <option value="72hs">72hs</option>
          </select>
        </div>

        <!-- Filtro de ordenación por valor -->
        <div class="col-md-4">
          <label for="ordenar" class="form-label fs-5">Ordenar por:</label>
          <select id="ordenar" name="ordenar" class="form-select form-select-xl">
            <option value="">Sin orden</option>
            <option value="ASC">Menor a mayor valor</option>
            <option value="DESC">Mayor a menor valor</option>
          </select>
        </div>

        <!-- Botón de búsqueda -->
        <div class="col-12 d-flex justify-content-center">
          <button type="submit" id="buscarBtn" class="btn btn-primary w-10">Buscar</button>
        </div>
      </form>


      <!-- Modal de Selección de Región -->
      <div class="modal fade" id="regionModal" tabindex="-1" aria-labelledby="regionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="regionModalLabel">Selecciona tu región</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
              <h4>Selecciona tu región:</h4>
              <button id="btnArgentina" class="btn btn-primary mx-2" onclick="seleccionarRegion('local')">🇦🇷
                Argentina</button>
              <button id="btnRestoMundo" class="btn btn-primary mx-2" onclick="seleccionarRegion('internacional')">🌍
                Resto del Mundo</button>
            </div>

          </div>
        </div>
      </div>

      <!-- Contenedor para todas las tarjetas -->
      <div class="row d-flex" id="cardContainer" style="display: none;">
        <!-- Las tarjetas se llenarán dinámicamente mediante AJAX -->
      </div>
      <div id="paginacion" class="text-center mt-4"></div>



    </div>
  </section>

  <!--Psicologos end-->


  <section class="service" id="service">

    <h1 class="headingService" id='tesxt'> BENEFICIOS </h1>

    <div class="box-container">

      <div class="box">
        <i class="bi bi-arrow-right-circle"></i>
        <p>
          Facilidad de acceso : Permite encontrar profesionales fácilmente desde la comodidad de tu hogar, sin necesidad
          de desplazarte básicamente a una consulta.
        </p>
      </div>

      <div class="box">
        <i class="fa fa-search" aria-hidden="true"></i>
        <p>
          Amplia variedad de opciones : Al buscar en una plataforma, tendrás acceso a una amplia gama de profesionales
          de diferentes especialidades y experiencias.
        </p>
      </div>

      <div class="box">
        <i class="fas fa-info-circle"></i>
        <p>
          Información detallada: Las plataformas suelen proporcionar información detallada sobre los profesionales, como
          su formación, áreas de especialización, opiniones de otros usuarios y tarifas.
        </p>
      </div>

      <div class="box">
        <i class="fas fa-balance-scale"></i>
        <p>
          Facilidad para comparar: Puedes comparar fácilmente entre varios profesionales en función de sus credenciales,
          opiniones de otros usuarios y servicios ofrecidos.
        </p>
      </div>


      <div class="box">
        <i class="fas fa-envelope"></i>
        <p>
          Posibilidad de contacto directo: Muchas plataformas permiten el contacto directo con el profesional antes de
          programar una cita, lo que te brinda la oportunidad de plantear tus dudas y conocer mejor al profesional.
        </p>
      </div>


      <div class="box">
        <i class="fas fa-lock"></i>
        <p>
          Seguridad y confianza: Las plataformas suelen contar con sistemas de verificación y garantías de protección de
          datos para brindarte mayor seguridad al buscar profesionales.
        </p>
      </div>


    </div>

  </section>

  <!-- service section ends -->

  <!-- footer section starts  -->

  <section class="footer">

    <div class="box-container">

      <div class="box">
        <a href="index.php" class="logo">
          <img src="../img/Logo_transparente.png" alt="Logo de Terapia Libre">
          Terapia Libre
        </a>
        <p>
          Es una plataforma innovadora que te ofrece la libertad de elegir al profesional de salud mental
          ideal para ti. Con una amplia variedad de expertos, facilitamos la búsqueda y selección de tu
          terapeuta, priorizando tu bienestar emocional con tratamientos personalizados.
        </p>
      </div>

      <div class="box">
        <h3 class="share">Redes</h3>
        <a href="https://www.instagram.com/terapia.libre/?igsh=MTE3cnBnYXB5OHVwZA%3D%3D"><i class="bi bi-instagram"></i>
          Instagram</a>
      </div>



    </div>

    <h1 class="credit">created by <span>WorldSoftSystem</span> | all rights reserved. </h1>

  </section>

  <!-- footer section ends -->


  <!-- custom js file link  -->
  <script src="https://sdk.mercadopago.com/js/v2"></script>

</body>

</html>