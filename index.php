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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="estilos/headerYFooter.css">
    <link rel="stylesheet" href="estilos/style.css">




    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- WOW.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <!-- bootrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>


    <!-- Agrega los scripts de Bootstrap y jQuery justo antes de cerrar la etiqueta </body> -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>

    <!-- header section starts  -->

    <header class="d-flex justify-content-between align-items-center bg-white shadow fixed-top p-2">
        <a href="index.php" class="logo d-flex align-items-center text-decoration-none text-success mx-auto mx-lg-0">
            <img src="./img/Logo_transparente.png" alt="Logo de Terapia Libre" class="mr-2" style="width: 7rem;">
            <span>Terapia Libre</span>
        </a>

        <nav class="navbar navbar-expand-lg navbar-light d-none d-lg-flex">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#home">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">Nosotros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#service">¿Cuándo acudir a nosotros?</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./cargaDatosPsicologos/carga.php">Soy un profesional</a>
                </li>
            </ul>
        </nav>

        <!-- Menú tipo TikTok solo visible en móviles -->
        <nav class="mobile-navbar d-lg-none fixed-bottom bg-white p-2 shadow">
            <ul class="d-flex justify-content-between w-100 text-center">
                <li>
                    <a href="#home">
                        <i class="fas fa-home"></i>
                        <p>Inicio</p>
                    </a>
                </li>
                <li>
                    <a href="#about">
                        <i class="fas fa-info-circle"></i>
                        <p>Nosotros</p>
                    </a>
                </li>
                <li>
                    <a href="#service">
                        <i class="fas fa-hands-helping"></i>
                        <p>¿Cuándo acudir?</p>
                    </a>
                </li>
                <li>
                    <a href="./cargaDatosPsicologos/carga.php">
                        <i class="fas fa-user-md"></i>
                        <p>Profesional</p>
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    <!-- header section ends -->


    <!-- header section ends -->

    <!-- home section starts  -->

    <section class="home" id="home">

        <div class="content">

            <h1 class="wow animate__animated animate__zoomIn">ENCUENTRA DE INMEDIATO EL PROFESIONAL PARA INICIAR TU
                TRATAMIENTO.</h1>
            <p class="wow animate__animated animate__zoomIn">Elegí entre más de 1000 especialistas,
                tu asistencia terapéutica de forma inmediata
                con turnos a partir de 24 hs.
            </p>
            <a href="./psicologos/psicologosOnline.php"><button class="btn wow animate__animated animate__zoomIn">BUSCAR UN PROFESIONAL</button></a>

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
        <div class="container py-5">
            <div class="container py-5">
                <div class="row align-items-center">
                    <!-- Video a la izquierda con un margen superior y un pequeño margen a la derecha, oculto en móviles -->
                    <div class="col-lg-5 col-md-12 mb-4 mb-lg-0 d-none d-md-block" style="margin-top: 16rem;">
                        <video class="w-75 ms-lg-3" autoplay loop muted>
                            <source src="img/nuevoCerebro.mp4" type="video/mp4">
                            Tu navegador no soporta el elemento de video.
                        </video>
                    </div>
                    <!-- Contenido a la derecha -->
                    <div class="col-lg-7 col-md-12">
                        <h1 class="quienesSomos wow animate__animated animate__backInLeft"
                            style="font-size: 3rem; margin-bottom: 20px;">
                            Quienes Somos
                        </h1>
                        <p class="wow animate__animated animate__backInLeft" style="font-size: 2rem;">
                            En nuestra plataforma web, nos encargamos de conectar a los usuarios que requieren atención
                            terapéutica con profesionales altamente competentes. Buscamos facilitar el acceso a
                            servicios de
                            psicoterapia individual de forma conveniente, contando con una amplia variedad de
                            profesionales
                            que ofrecen diferentes especialidades y enfoques terapéuticos. De esta manera, los usuarios
                            tienen
                            la oportunidad de seleccionar al terapeuta que mejor se ajuste a sus necesidades y les
                            acompañe en
                            el proceso de recuperación.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <h1 class="heading wow animate__animated animate__backInLeft" data-wow-delay="0.6s">Comentarios</h1>
            <div class="slider">
                <div class="item">
                    <p>Agradezco mucho por la ayuda recibida durante nuestras sesiones. Su profesionalismo y apoyo han
                        sido fundamentales para mi bienestar emocional. ¡Gracias por tanto!</p>

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

        <h1 class="heading wow animate__animated animate__backInLeft" data-wow-delay="0.6s">¿En qué situaciones deberías
            acudir a nuestros profesionales de salud mental?</h1>

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