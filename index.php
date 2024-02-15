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
    <link rel="stylesheet" href="estilos/style.css">

    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>

    
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
                <li><a href="#home">Inicio</a></li>
                <li><a href="#about">Nosotros</a></li>
                <li><a href="#service">¿Cuando acudir a nosotros?</a></li>

            </ul>
        </nav>

        <div class="fas fa-bars"></div>

    </header>

    <!-- header section ends -->

    <!-- home section starts  -->

    <section class="home" id="home">

        <div class="content">

            <h1>ENCUENTRA DE INMEDIATO EL PROFESIONAL PARA INICIAR TU TRATAMIENTO.</h1>
            <p>Elegí entre más de 1000 especialistas,
                tu asistencia terapéutica de forma inmediata
                con turnos a partir de 24 hs.
            </p>
            <a href="./psicologos/psicologosOnline.php"><button class="btn">BUSCAR UN PROFESIONAL </button></a>

        </div>

    </section>

    <!-- home section ends -->

    <!--icono flotante whatsapp 
    <a href="https://api.whatsapp.com/send?phone=5491161536595" class="btn-wsp" target="_blank">
	    <i class="fa fa-whatsapp icono"></i>
	</a>
    -->
    
    <!-- about section starts  -->

    <section class="about" id="about">

        <h1 class="heading"> <i class="fas fa-quote-left"></i> QUIENES SOMOS <i class="fas fa-quote-right"></i> </h1>

        <div class="row">

            <div class="image">
                <img src="img/about.jpg" alt="Paciente con psicologo">
            </div>

            <div class="content">
                <p>
                    Terapia Libre ofrece una amplia gama de profesionales con diferentes especialidades y enfoques
                    terapéuticos, lo que les permitirá encontrar el terapeuta que los acompañe en el proceso de
                    restablecer una óptima salud mental.
                </p>

            </div>

        </div>

        <div class="box-container">

            <div class="box">
                <i class="fas fa-users"></i>
                <h3>1000+</h3>
                <p>Pacientes</p>
            </div>

            <div class="box">
                <i class="fas fa-hand-holding-heart"></i>
                <h3>200+</h3>
                <p>Profesionales</p>
            </div>

            <div class="box">
                <i class="bi bi-clock"></i>
                <h3>24 hs</h3>
                <p>Profesionales de guardia</p>
            </div>

        </div>

    </section>

    <!-- about section ends -->

    <!-- service section starts  -->

    <section class="service" id="service">

        <h1 class="headingService">¿En qué situaciones deberías acudir a nuestros profesionales de salud mental?</h1>

        <div class="box-container">

            <div class="box">
                <i class="fas fa-user-clock"></i>
                <p>Cuando sientas que la tristeza, la apatía y la falta de ilusión empiezan a agobiarte
                    o pienses que tu vida carece de sentido mismo.
                </p>
            </div>

            <div class="box">
                <i class="	fas fa-user-alt"></i>
                <p>Cuando te sientes solo, incomprendido o desatendido o piensas que la desgracia se ha
                    cebado contigo y comienzas a asumir que todo te sale mal y que las cosas no van a cambiar.</p>
            </div>

            <div class="box">
                <i class="fas fa-user-friends"></i>
                <p>Cuando tengas miedo de salir a la calle, relacionarte, estar en sitios cerrados, viajar…,
                    y ello te impide desarrollar tus habilidades y disfrutar de lo que te rodea.</p>
            </div>

            <div class="box">
                <i class="fas fa-lungs"></i>
                <p>Cuando tengas síntomas como taquicardias, palpitaciones, insomnio, problemas digestivos y
                    otros, que puedas relacionar con situaciones de estrés.</p>
            </div>

            <div class="box">
                <i class="fas fa-head-side-cough"></i>
                <p>Cuando la obsesión por padecer enfermedades o contagiarte de ellas te lleva a conductas extrañas
                    y repetitivas, de las que no puedes prescindir sin que su ausencia te genere ansiedad.</p>
            </div>


        </div>

    </section>

    <!-- service section ends -->


    <!-- footer section starts  -->

    <section class="footer">

        <div class="box-container">

            <div class="box">
                <a href="index.php" class="logo">
                    <img src="img/Logo_transparente.png" alt="Logo de Terapia Libre">
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
    <script src="scripts/script.js"></script>

</body>

</html>