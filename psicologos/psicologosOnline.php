<?php
// Incluir la conexión a la base de datos
include '../php/conexion.php';

// Consulta para obtener las especialidades
$sql = "SELECT DISTINCT especi FROM especialidades ORDER BY especi";

$especialidades = $conexion->query($sql);


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
      </ul>
    </nav>

  </header>

  <!--header section ends-->

  <!--Psicologos start-->
  <section id="profesionales">
    <h1 class="heading"> PROFESIONALES </i></h1>

    <div class="container my-4">
      <!-- Formulario de filtros con Bootstrap -->
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" class="row g-3">
        <!-- Filtro de especialidad -->
        <div class="col-md-4">
          <label for="especialidadFilter" class="form-label fs-5">Especialidad:</label>
          <select id="especialidadFilter" name="especialidadFilter" class="form-select form-select-xl">
            <option value="">Todos</option>
            <?php
            if ($especialidades->num_rows > 0) {
              while ($row = $especialidades->fetch_assoc()) {
                echo '<option value="' . htmlspecialchars($row['especi']) . '">' . htmlspecialchars($row['especi']) . '</option>';
              }
            } else {
              echo '<option value="">No hay especialidades disponibles</option>';
            }
            ?>
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

      <!-- Contenedor para todas las tarjetas -->
      <div class="row d-flex" id="cardContainer">
        <?php
        // Incluye el archivo de conexión a la base de datos
        include_once '../php/conexion.php';


        // Inicializa la consulta SQL
        $sql = "SELECT * FROM presentaciones";
        $conexion->set_charset('utf8');
        // Verifica si se han enviado filtros
        if (isset($_GET['disponibilidadFilter']) && !empty($_GET['disponibilidadFilter'])) {
          $disponibilidadFilter = $_GET['disponibilidadFilter'];
          $sql .= " WHERE disponibilidad = '$disponibilidadFilter'";
        }

        // Manejo del filtro de especialidad
        if (isset($_GET['especialidadFilter']) && $_GET['especialidadFilter'] !== '') {
          $especialidadFilter = $_GET['especialidadFilter'];
          // Modifica la condición de especialidad para usar LIKE
          $sql .= (strpos($sql, 'WHERE') !== false) ? " AND especialidad LIKE '%$especialidadFilter%'" : " WHERE especialidad LIKE '%$especialidadFilter%'";
        }

        // Verifica si se ha enviado el filtro de orden
        if (isset($_GET['ordenar']) && !empty($_GET['ordenar'])) {
          $ordenar = $_GET['ordenar'];
          if ($ordenar == 'ASC') {
            // Ordenar de menor a mayor valor
            $sql .= " ORDER BY valor ASC, disponibilidad ASC";
          } else {
            // Ordenar de mayor a menor valor
            $sql .= " ORDER BY valor DESC, disponibilidad ASC";
          }
        } else {
          // Por defecto, ordena por disponibilidad
          $sql .= " ORDER BY disponibilidad ASC";
        }


        $result = $conexion->query($sql);

        // Verifica si hay resultados
        if ($result->num_rows > 0) {
          // Genera dinámicamente el HTML para cada psicólogo
          while ($row = $result->fetch_assoc()) {
            echo "
            <div class='col-lg-4 col-md-6 mb-3 d-flex justify-content-center'>
                <div class='card'>
                <span class='tooltiptext'>$ {$row['valor']}</span>
                    <img src='{$row['rutaImagen']}' class='card-img-top' alt='...'>
                    <div class='card-body'>
                        <h5 class='card-title'>{$row['nombre']}</h5>
                        <div class='rating'>
                            <span class='fa fa-star checked'></span>
                            <span class='fa fa-star checked'></span>
                            <span class='fa fa-star checked'></span>
                            <span class='fa fa-star checked'></span>
                            <span class='fa fa-star unchecked'></span>
                            <p>3.5</p>
                        </div>
                        <h5 class='card-titleDos'>{$row['titulo']}</h5>
                        <p class='card-text'>{$row['especialidad']}</p>
                        <p class='card-text-diponibilidad'>Disponibilidad en: {$row['disponibilidad']}hs</p>
                        <a href='#' class='btn btn-primary' data-id='{$row['id']}' onclick='mostrarInformacion(this)'>Más información</a>
                    </div>
                </div>
            </div>
            ";
          }
        } else {
          echo '<div class="no-results-message">No hay psicólogos disponibles.</div>';
        }


        // Cierra la conexión a la base de datos
        $conexion->close();
        ?>
      </div>




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
  <script src="../scripts/scriptPsicologos.js"></script>
  <script src="https://sdk.mercadopago.com/js/v2"></script>

</body>

</html>