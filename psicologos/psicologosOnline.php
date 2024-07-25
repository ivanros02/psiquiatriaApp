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

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>

  <!-- header section starts  -->

  <header>

    <a href="../index.php" class="logo">
      <img src="../img/Logo_transparente.png" alt="Logo de Terapia Libre">
      Terapia Libre
    </a>

    <nav class="navbar">
      <ul>
        <li><a href="../index.php">Inicio</a></li>
        <li><a href="#service">Beneficios</a></li>

      </ul>
    </nav>

    <div class="fas fa-bars"></div>

  </header>

  <!--header section ends-->

  <!--Psicologos start-->
  <section id="profesionales">
    <h1 class="heading"> PROFESIONALES </i></h1>

    <div class="container">
      <!-- Agrega el nuevo contenedor para el filtro -->
      <!-- Agrega este formulario que envía los datos mediante el método GET -->
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
        <div class="filter-container">
          <label for="especialidadFilter">Especialidad:</label>
          <select id="especialidadFilter" name="especialidadFilter">
            <option value="">Todos</option>
            <?php
            if ($especialidades->num_rows > 0) {
              // Salida de cada fila
              while ($row = $especialidades->fetch_assoc()) {
                echo '<option value="' . htmlspecialchars($row['especi']) . '">' . htmlspecialchars($row['especi']) . '</option>';
              }
            } else {
              echo '<option value="">No hay especialidades disponibles</option>';
            }
            ?>
          </select>

          <label for="disponibilidadFilter">Disponibilidad:</label>
          <select id="disponibilidadFilter" name="disponibilidadFilter">
            <option value="">Todas las disponibilidades</option>
            <option value="24hs">24hs</option>
            <option value="48hs">48hs</option>
            <option value="72hs">72hs</option>
          </select>


          <label for="ordenar">Valor:</label>
          <select id="ordenar" name="ordenar">
            <option value="">Todas las disponibilidades</option>
            <option value="ASC">Menor a mayor valor</option>
            <option value="DESC">Mayor a menor valor</option>
          </select>

          <!-- Cambia el tipo de botón a submit para enviar el formulario -->
          <button type="submit" id="buscarBtn">Buscar</button>
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
        <a href="https://www.instagram.com/terapia.libre/?igsh=MTE3cnBnYXB5OHVwZA%3D%3D"><i
                        class="bi bi-instagram"></i> Instagram</a>
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