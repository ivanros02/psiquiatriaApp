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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

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
      <div class="filter-container">
        <label for="especialidadFilter">Especialidad:</label>
        <select id="especialidadFilter">
          <option value="">Todas las especialidades</option>
          <option value="Ansiedad y estrés">Ansiedad y estrés</option>
          <option value="Desarrollo personal">Desarrollo personal</option>
          <!-- Agrega las demás opciones de especialidades aquí -->
        </select>

        <!-- Agrega un nuevo filtro para la disponibilidad -->
        <label for="disponibilidadFilter">Disponibilidad:</label>
        <select id="disponibilidadFilter">
          <option value="">Todas las disponibilidades</option>
          <option value="24hs">24hs</option>
          <option value="48hs">48hs</option>
          <option value="72hs">72hs</option>
          <!-- Agrega las demás opciones de disponibilidad aquí -->
        </select>

        <button id="buscarBtn">Buscar</button>
      </div>


      <!-- Contenedor para todas las tarjetas -->
      <div class="row" id="cardContainer">
        <!-- Las tarjetas se generarán dinámicamente aquí -->
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
        <a href="#profesionales" class="logo">
          <img src="img/Logo_transparente.png" alt="Logo de Terapia Libre">
          Terapia Libre
        </a>
        <p>
          Es una plataforma innovadora que te brinda la libertad de elegir al profesional de salud mental que mejor se
          adapte a tus
          necesidades. Con una amplia variedad de expertos y especialistas, la plataforma facilita la búsqueda y
          selección de tu terapeuta
          ideal. Priorizamos la salud mental, ofreciéndote un espacio donde puedas acceder a tratamientos personalizados
          y dedicados a
          mejorar tu bienestar emocional.
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
  <script src="scripts/scriptPsicologos.js"></script>
  <script src="https://sdk.mercadopago.com/js/v2"></script>

</body>

</html>