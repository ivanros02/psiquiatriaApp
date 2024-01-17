<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Terapia Libre</title>

  <!--icono pestana-->
  <link rel="icon" href="img/Logo_transparente.png" type="image/x-icon">
  <link rel="shortcut icon" href="img/Logo_transparente.png" type="image/x-icon">

  <!-- font awesome cdn link  -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
  <!-- custom css file link  -->
  <link rel="stylesheet" href="estilos/stylePsico.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>

  <!-- header section starts  -->

  <header>

    <a href="index.php" class="logo">
      <img src="img/Logo_transparente.png" alt="Logo de Terapia Libre">
      Terapia Libre
    </a>

    <nav class="navbar">
      <ul>
        <li><a href="index.php">Inicio</a></li>
        <li><a href="#service">Servicios</a></li>

      </ul>
    </nav>

    <div class="fas fa-bars"></div>

  </header>

  <!--header section ends-->

  <!--Psicologos start-->
  <section id="profesionales">
    <h1 class="heading"><i class="fas fa-quote-left"></i> Profesionales <i class="fas fa-quote-right"></i></h1>

    <div class="container">
      <!-- search content -->
      <div class="search-container">
        <input type="text" id="searchInput" placeholder="Buscar profesional" />
      </div>
      <p id="noResults" class="no-results">No se encontraron resultados.</p>

      <!-- Contenedor para todas las tarjetas -->
      <div class="row" id="cardContainer">
        <!-- Las tarjetas se generarán dinámicamente aquí -->
      </div>

    </div>
  </section>

  <!--Psicologos end-->

  <section class="service" id="service">

    <h1 class="heading"> <i class="fas fa-quote-left"></i> Nuestras terapias <i class="fas fa-quote-right"></i> </h1>

    <div class="box-container">

      <div class="box">
        <i class="	fas fa-wifi"></i>
        <p>
          Tratamiento psicológico online, sin necesidad de moverte de casa.
        </p>
      </div>

      <div class="box">
        <i class="fas fa-book-open"></i>
        <p>
          Con evaluación previa para analizar tu caso.
        </p>
      </div>

      <div class="box">
        <i class="fas fa-hands-helping"></i>
        <p>
          Un gestor te ayudará con las siguientes consultas.
        </p>
      </div>

      <div class="box">
        <i class="	fas fa-id-badge"></i>
        <p>
          Con los mejores profesionales en salud mental.
        </p>
      </div>

    </div>

  </section>

  <!-- service section ends -->

  <!-- footer section starts  -->

  <section class="footer">

    <div class="box-container">

      <div class="box">
        <a href="#profesionales" class="logo">
          <img src="img/Logo_transparente.png" alt="Logo de Terapia Libre">
          Terapia Libre
        </a>
        <p>
          Te da la posibilidad de contactar a distancia la salud mental online acercandonos a
          donde estes y ofreciendote la mejor atencion, con la finalidad de atender tus necesidades
          con los mejores profesionales.
        </p>
      </div>

      <div class="box">
        <h3 class="share">Redes</h3>
        <a href="#">instagram</a>
      </div>


    </div>

    <h1 class="credit">created by <span>WorldSoftSystem</span> | all rights reserved. </h1>

  </section>

  <!-- footer section ends -->


  <!-- custom js file link  -->
  <script src="scripts/scriptPisco.js"></script>
  <script src="https://sdk.mercadopago.com/js/v2"></script>

</body>

</html>