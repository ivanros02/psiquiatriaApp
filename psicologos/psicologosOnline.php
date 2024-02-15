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
    <h1 class="heading"><i class="fas fa-quote-left"></i> PROFESIONALES <i class="fas fa-quote-right"></i></h1>

    <div class="container">
      <!-- Agrega el nuevo contenedor para el filtro -->
      <!-- Agrega este formulario que envía los datos mediante el método GET -->
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
        <div class="filter-container">
          <label for="especialidadFilter">Especialidad:</label>
          <select id="especialidadFilter" name="especialidadFilter">
            <option value="">Todas las disponibilidades</option>
            <option value="Ansiedad y estrés">Ansiedad y estrés</option>
            <option value="Desarrollo personal">Desarrollo personal</option>
            <option value="Miedos al COVID-19">Miedos al COVID-19</option>
          </select>

          <label for="disponibilidadFilter">Disponibilidad:</label>
          <select id="disponibilidadFilter" name="disponibilidadFilter">
            <option value="">Todas las disponibilidades</option>
            <option value="24hs">24hs</option>
            <option value="48hs">48hs</option>
            <option value="72hs">72hs</option>
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

        // Verifica si se han enviado filtros
        if (isset($_GET['disponibilidadFilter']) && !empty($_GET['disponibilidadFilter'])) {
          $disponibilidadFilter = $_GET['disponibilidadFilter'];
          $sql .= " WHERE disponibilidad = '$disponibilidadFilter'";
        }

        if (isset($_GET['especialidadFilter']) && !empty($_GET['especialidadFilter'])) {
          $especialidadFilter = $_GET['especialidadFilter'];
          // Modifica la condición de especialidad para usar LIKE
          $sql .= (strpos($sql, 'WHERE') !== false) ? " AND especialidad LIKE '%$especialidadFilter%'" : " WHERE especialidad LIKE '%$especialidadFilter%'";
        }
        

        // Finaliza la consulta SQL y agrega la ordenación por disponibilidad
        $sql .= " ORDER BY disponibilidad ASC";

        $result = $conexion->query($sql);

        // Verifica si hay resultados
        if ($result->num_rows > 0) {
          // Genera dinámicamente el HTML para cada psicólogo
          while ($row = $result->fetch_assoc()) {
            echo "
            <div class='col-lg-4 col-md-6 mb-3 d-flex justify-content-center'>
                <div class='card'>
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

    <h1 class="headingService" id='tesxt'> <i class="fas fa-quote-left"></i> BENEFICIOS <i
        class="fas fa-quote-right"></i> </h1>

    <div class="box-container">

      <div class="box">
        <i class="bi bi-lightbulb"></i>
        <p>
          Tratamiento terapéutico sin necesidad de moverte de tu casa
        </p>
      </div>

      <div class="box">
        <i class="fa fa-balance-scale" aria-hidden="true"></i>
        <p>
          Sin autorizaciones burocráticas y complejas.
        </p>
      </div>

      <div class="box">
        <i class="fas fa-hands-helping"></i>
        <p>
          Fácil y rápido acceso al tratamiento.
          Turnos a partir de 24 hs, 48 hs
          <br>y 72 hs.
        </p>
      </div>

      <div class="box">
        <i class="	fas fa-id-badge"></i>
        <p>
          Seleccioná el profesional de la salud mental de acuerdo a tu necesidad.
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
                <a href="#">Instagram</a>
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