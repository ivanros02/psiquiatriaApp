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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="stylesheet" href="estilos/headerYFooter.css">    
    <link rel="stylesheet" href="estilos/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <script src="https://kit.fontawesome.com/eb496ab1a0.js" crossorigin="anonymous"></script>



</head>

<body>

    <!-- header section starts  -->

    <header>

        <a href="index.php" class="logo">
            <img src="./img/Logo_transparente.png" alt="Logo de Terapia Libre">
            Terapia Libre
        </a>

        <nav class="navbar">
            <ul>
                <li><a href="#home">Inicio</a></li>
                <li><a href="#about">Nosotros</a></li>
                <li><a href="#service">¿Cuando acudir a nosotros?</a></li>
                <li><a href="./cargaDatosPsicologos/carga.php">Soy un profesional</a></li>

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
        <div class="row">
            <div class="video">
                <video autoplay loop muted>
                    <source src="img/nuevoCerebro.mp4" type="video/mp4">
                    Tu navegador no soporta el elemento de video.
                </video>
            </div>
            <div class="content">
                <h1 class="heading" >Quienes <br> Somos</h1>
                <p>
                    En nuestra plataforma web, nos encargamos de conectar a los usuarios que requieren atención
                    terapéutica con profesionales altamente competentes. Buscamos facilitar el acceso a servicios de
                    psicoterapia individual de forma conveniente, contando con una amplia variedad de profesionales que
                    ofrecen diferentes especialidades y enfoques terapéuticos. De esta manera, los usuarios tienen la
                    oportunidad de seleccionar al terapeuta que mejor se ajuste a sus necesidades y les acompañe en el
                    proceso de recuperación.
                </p>
            </div>
        </div>

        <div class="container">
            <h1 class="heading">Comentarios</h1>
            <div class="slider">
                <div class="item">
                    <p>Agradezco mucho por la ayuda recibida durante nuestras sesiones. Su profesionalismo y apoyo han
                        sido fundamentales para mi bienestar emocional. ¡Gracias por tanto!</p>
                    <img class="imgCard" src="./img/Lic. Vanesa Pérez.jpg" alt="logo comentario">
                    <p class='userComment'>Nombre ejemplo</p>
                </div>
                <div class="item">
                    <p>Quiero agradecer sinceramente por la atención psicológica recibida. Su apoyo ha sido fundamental
                        para mi bienestar emocional.</p>
                </div>
                <div class="item">
                    <p>Agradezco mucho por la ayuda recibida durante nuestras sesiones. Su profesionalismo y apoyo han
                        sido fundamentales para mi bienestar emocional. Gracias!!</p>
                </div>
                <div class="item">
                    <p>Quería expresar mi más sincero agradecimiento por la atención recibida. Su profesionalismo y
                        apoyo han sido de gran ayuda para mí."
                        "Quiero agradecer por el tratamiento recibido. Su ayuda ha sido fundamental para mí. Gracias por
                        todo! </p>
                </div>
                <div class="item">
                    <p>Quisiera expresar mi agradecimiento por las rápidas evoluciones terapéuticas que experimente.</p>
                </div>
                <div class="item">
                    <p>Su apoyo y orientación han sido fundamentales en mi proceso de sanación y crecimiento personal.
                        ¡Gracias por hacer posible estos avances tan significativos!</p>
                </div>
                <button id="next">></button>
                <button id="prev"><</button>
            </div>
        </div>
    </section>





    <!-- about section ends -->

    <!-- service section starts  -->

    <section class="service" id="service">

        <h1 class="heading">¿En qué situaciones deberías acudir a nuestros profesionales de salud mental?</h1>

        <div class="box-container">

            <div class="box">
                <i class="fas fa-user-clock"></i>
                <p>Síntomas persistentes: Si experimentas emociones persistentes como tristeza intensa, ansiedad
                    abrumadora o cambios en el sueño o alimentación, busca ayuda profesional.
                </p>
            </div>

            <div class="box">
                <i class="	fas fa-user-alt"></i>
                <p>Estrés y abrumadores: Si te sientes abrumado/a por el estrés o la ansiedad, un terapeuta puede
                    brindarte herramientas para manejar estas emociones.
                </p>
            </div>

            <div class="box">
                <i class="fas fa-user-friends"></i>
                <p>Eventos traumáticos o pérdidas: Si has sufrido eventos traumáticos o pérdidas significativas,
                    hablar con un profesional puede ayudarte a superar estas experiencias.</p>
            </div>

            <div class="box">
                <i class="fas fa-lungs"></i>
                <p>Problemas de autoestima: Si tienes baja autoestima o problemas de autoimagen, un terapeuta puede
                    ayudarte a mejorar tu confianza y bienestar emocional.</p>
            </div>

            <div class="box">
                <i class="fas fa-head-side-cough"></i>
                <p>Trastornos mentales diagnosticados: Si has sido diagnosticado/a con trastornos mentales como
                    depresión o ansiedad, es importante buscar tratamiento profesional para manejarlos efectivamente.
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
                <a href="https://www.instagram.com/terapia.libre/?igsh=MTE3cnBnYXB5OHVwZA%3D%3D"><i
                        class="bi bi-instagram"></i> Instagram</a>
            </div>



        </div>

        <h1 class="credit">created by <span>WorldSoftSystem</span> | all rights reserved. </h1>

    </section>

    <!-- footer section ends -->


    <!-- custom js file link  -->
    <script src="scripts/script.js"></script>

</body>

</html>